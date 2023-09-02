<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\OrderBuyer\OrderBuyerStoreRequest;
use App\Models\User;
use App\Models\User\OrderBuyer;
use App\Models\User\Product;
use App\Models\User\Storage;
use App\Models\User\StorageProduct;
use App\Models\User\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;



class OrderBuyerController extends Controller
{
    public function index(Request $request)
    {
        //Get status
        $statusList = config('constants.status_receipt_list');
        $data = OrderBuyer::with('supplier', 'storage')->where('status','<>',0)->orderBy('id', 'DESC');
        $data = $data->paginate(5);
        return view('user.order.order-buyer.index', compact('data', 'statusList'));
    }

    public function create()
    {
        $suppliers = Supplier::get();
        $wareHouses = Storage::get();
        $products = Product::get();
        $statusList = config('constants.status_receipt_list');
        $companyInfo= config('companyInfo');
        $users = User::orderBy('id', 'DESC')->get()->filter(
            fn ($user) => $user->roles->where('name','<>', 'admin')->toArray()
        );
        return view('user.order.order-buyer.create', compact('suppliers', 'wareHouses', 'products', 'users', 'statusList', 'companyInfo'));
    }

    public function store(OrderBuyerStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = [];
            $data['code']           = $request->code;
            $data['supplier_id']    = $request->supplier_id;
            $data['storage_id']     = $request->storage_id;
            $data['order_info'] = json_encode([
                'estimate_delivery_time'    => $request->estimate_delivery_time,
                'receipt_date'              => $request->receipt_date,
                'buyer_name'                => $request->buyer_name,
                'buyer_address'             => $request->buyer_address,
                'buyer_tax_code'            => $request->buyer_tax_code
            ]);
            $data['created_by']         =   Auth::user()->id;
            $data['assignee']           =   Auth::user()->id;
            $data['order_approver']     =   $request->order_approver;
            $data['warehouse_keeper']     =   $request->warehouse_keeper;
            $order = OrderBuyer::create($data);
            DB::commit();
            return redirect()->route('order-buyer.show', $order->id);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {
            $data = OrderBuyer::find($id);
            if (!$data) {
                return redirect('/');
            }

            $statusList = config('constants.status_receipt_list');
            $order_info = json_decode($data->order_info);
            $warehouse_recript = json_decode($data->warehouse_recript);
            $product_info = ($data->products===null)?[]:$data->products;

            $product_ids = $this->getProductIds($product_info);
            $products = Product::whereNotIn('id', $product_ids)->get();

            DB::commit();
            return view('user.order.order-buyer.show', compact('data', 'statusList', 'order_info', 'products', 'product_info', 'warehouse_recript'));
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
            $data = OrderBuyer::find($id);
            $product_info = $data->products;
            $products = [];
            $product = $request->except('_token');
            $getProduct = Product::find($request->product_id);
            $product['name'] = $getProduct->name;
            $product['price'] = $getProduct->price;
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
            return redirect()->route("order-buyer.show", $id);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }


    }

    public function deleteProduct($product_id, $order_id)
    {

        DB::beginTransaction();
        try {
            $data = OrderBuyer::find($order_id);
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
            return redirect()->route("order-buyer.show", $order_id);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function addWareHouseRecript(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = OrderBuyer::find($id);
            $data->warehouse_recript = $request->except('_token');
            $data->save();
            $this->updateStatus($id, 5);
            DB::commit();
            return redirect()->route("order-buyer.show", $id);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function updateStatus($order_id, $status_id)
    {
        DB::beginTransaction();
        try {
            $data = OrderBuyer::find($order_id);
            if($data->assignee != auth()->user()->id) {
                return redirect()->back()->with(['error' => "Bạn không được phép thực hiện thao tác này"])->withInput();
            }
            $data->status = $status_id;
            $data->assignee = ($status_id < 3 || $status_id == 4 || $status_id == 7) ? $data->created_by : (($status_id == 3 || $status_id == 5) ? $data->order_approver : $data->warehouse_keeper);
            $data->save();

            if ($status_id == 7) {
               $products = $data->products;
               foreach ($products as $key => $value) {
                    StorageProduct::create([
                        'storage_id'        =>  $data->storage_id,
                        'product_id'        =>  $value['product_id'],
                        'quantity_plus'     =>  $value['quantity'],
                        'quantity_mins'     =>  $value['quantity'],
                        'in_stock'          =>  $value['quantity'],
                        'sold'              =>  $value['quantity'],
                        'order_buyer_id'    =>  $order_id,
                        'product_info'      =>  json_encode($value),
                    ]);
               }
            }
            DB::commit();
            return redirect()->route("order-buyer.show", $order_id);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }


    public function purchaseOrderExport($id)
    {
        try {
            $data = OrderBuyer::find($id);
            if (!$data) {
                return redirect('/');
            }
            $order_info = json_decode($data->order_info);
            $products = $data->products;

            $pdf = PDF::loadView('user.order.order-buyer.purchase-order-export', compact('data','order_info','products'));
            return $pdf->download('purchase-order-export' . date('YmdHms') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function wareHouseRecript($id)
    {
        try {
            $data = OrderBuyer::find($id);
            if (!$data) {
                return redirect('/');
            }
            $order_info = json_decode($data->order_info);
            $products = $data->products;

            $warehouse_recript = json_decode($data->warehouse_recript);
            // return view('user.order.order-buyer.warehouse-recript-export', compact('data','order_info','products','warehouse_recript'));
            $pdf = PDF::loadView('user.order.order-buyer.warehouse-recript-export', compact('data','order_info','products','warehouse_recript'));
            return $pdf->download('purchase-order-export' . date('YmdHms') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        $data = OrderBuyer::find($id);
        $code = $data->code;
        $data->delete();
        return redirect()->route('order-buyer.index')->with(['success' => 'Đã huỷ đơn hàng ' . $code]);
    }

}
