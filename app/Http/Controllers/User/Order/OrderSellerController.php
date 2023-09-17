<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\OrderSeller\OrderSellerStoreRequest;
use App\Models\User;
use App\Models\User\Customer;
use App\Models\User\OrderSeller;
use App\Models\User\Product;
use App\Models\User\Storage;
use App\Models\User\StorageProduct;
// use App\Models\User\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;



class OrderSellerController extends Controller
{
    public function index(Request $request)
    {
        //Get status
        $statusList = config('constants.status_order_seller');
        $data = OrderSeller::where('status','<>',0)
            ->where('assignee',auth()->user()->id)
            ->where('status','<>',6)
            ->orderBy('id', 'DESC');
        $data = $data->paginate(5);
        return view('user.order.order-seller.index', compact('data', 'statusList'));
    }

    public function orderCancel(Request $request)
    {
        dd(1);
        // //Get status
        // $statusList = config('constants.status_receipt_list');
        // $data = OrderSeller::onlyTrashed()->get();
        // $data = $data->paginate(5);
        // return view('user.order.order-seller.cancel', compact('data', 'statusList'));
    }

    public function create()
    {
        $customers = Customer::get();
        $users = User::orderBy('id', 'DESC')->get()->filter(
            fn ($user) => $user->roles->where('name','<>', 'admin')->toArray()
        );
        $storages = Storage::get();
        return view('user.order.order-seller.create', compact('customers', 'users', 'storages'));
    }

    public function store(OrderSellerStoreRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->all();
            $data['created_by']         =   Auth::user()->id;
            $order = OrderSeller::create($data);
            DB::commit();
            return redirect()->route('order-seller.show', $order->id);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {

            $data = OrderSeller::find($id);
            if (!$data) {
                return redirect('/');
            }
            $statusList = config('constants.status_order_seller');
            $product_info = ($data->products===null)?[]:$data->products;
            $product_ids = $this->getProductIds($product_info);
            // $products = Product::whereNotIn('id', $product_ids)->get();
            $storage = Storage::find($data->storage_id); // lấy kho
            $products = $storage->storage_product; // lấy sp trong kho
            $products = $products->whereNotIn('product_id', $product_ids); // loại bỏ sản phẩm đã add
            DB::commit();
            return view('user.order.order-seller.show', compact('data', 'statusList', 'products', 'product_info'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    private function getProductIds($products)
    {
        $data = [];
        foreach ($products as $key => $value) {
            $data[] = $value['product_id'];
        }
        return $data;
    }

    public function addProduct(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = OrderSeller::find($id);
            $product_info = $data->products;
            $products = [];
            $product = $request->except('_token');
            $getProduct = Product::find($request->product_id); dd();

            $product['name'] = $getProduct->name;
            $product['price'] = $getProduct->price_customer->where('customer_id', $data->customer_id)[0]->price;
            $product['unit'] = $getProduct->unit;
            $product['specification'] = $getProduct->specification;
            if ($product_info == null) {
                $products[] = $product;
                $data->products = $products;
            } else {
                $product_info[] = $product;
                $data->products = $product_info;
            }
            $data->save();
            DB::commit();
            return redirect()->route("order-seller.show", $id);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }


    }

    public function deleteProduct($product_id, $order_id)
    {

        DB::beginTransaction();
        try {
            $data = OrderSeller::find($order_id);
            $product_info = $data->products;
            $products = null;

            foreach ($product_info as $key => $value) {
                if ($value['product_id'] != $product_id) {
                    $products[] = $value;
                }
            }
            $data->products = $products;
            $data->save();
            DB::commit();
            return redirect()->route("order-seller.show", $order_id);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function addWareHouseRecript(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = OrderSeller::find($id);
            $data->warehouse_recript = $request->except('_token');
            $data->save();
            $this->updateStatus($id, 5);
            DB::commit();
            return redirect()->route("order-seller.show", $id);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function updateStatus($order_id, $status_id)
    {
        DB::beginTransaction();
        try {
            $data = OrderSeller::find($order_id);
            if($data->assignee != auth()->user()->id) {
                return redirect()->back()->with(['error' => "Bạn không được phép thực hiện thao tác này"])->withInput();
            }
            $data->status = $status_id;
            $data->assignee = ($status_id < 3 || $status_id == 5 || $status_id == 6) ? $data->created_by : ($status_id == 3 ? $data->order_approver : $data->warehouse_keeper);
            $data->save();

            if ($status_id == 7) {
               $products = $data->products;
               foreach ($products as $key => $value) {
                    StorageProduct::create([
                        'storage_id'        =>  $data->storage_id,
                        'product_id'        =>  $value['product_id'],
                        'quantity_plus'     =>  $value['quantity']/$value['specification'],
                        'quantity_mins'     =>  $value['quantity']/$value['specification'],
                        'in_stock'          =>  $value['quantity']/$value['specification'],
                        'sold'              =>  $value['quantity']/$value['specification'],
                        'order_buyer_id'    =>  $order_id,
                        'product_info'      =>  json_encode($value),
                    ]);
               }
            }
            DB::commit();
            return redirect()->route("order-seller.show", $order_id);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }


    public function toDeliverExport($id)
    {
        try {
            $data = OrderSeller::find($id);
            if (!$data) {
                return redirect('/');
            }
            $products = $data->products;

            $pdf = PDF::loadView('user.order.order-seller.to-deliver-export', compact('data','products'));
            return $pdf->download('purchase-order-export' . date('YmdHms') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function invoiceRequestForm($id)
    {
        try {
            $data = OrderSeller::find($id);
            if (!$data) {
                return redirect('/');
            }
            $products = $data->products;

            // return view('user.order.order-seller.warehouse-recript-export', compact('data','order_info','products','warehouse_recript'));
            $pdf = PDF::loadView('user.order.order-seller.invoice-request-form', compact('data','products'));
            return $pdf->download('purchase-order-export' . date('YmdHms') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        $data = OrderSeller::find($id);
        $data->status = 0;
        $code = $data->to_deliver_code;
        $data->save();
        return redirect()->route('order-seller.index')->with(['success' => 'Đã huỷ đơn hàng ' . $code]);
    }

}
