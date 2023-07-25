<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Order;
use App\Models\User\Customer;
use App\Models\User\Supplier;
use App\Models\User\Product;
use App\Models\User\Storage;
use App\Models\User\GoodsReceiptManagement;
use App\Models\User\ProductGoodsReceiptManagement;
use App\Models\User\PriceCustomerProdManagement;
use PDF;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Order::orderBy('id', 'DESC');
        if (isset($request->search)) {
            $search = $request->search;
            $columns = ['order_code', 'payment_method'];
            $data->where(function ($subQuery) use ($columns, $search) {
                foreach ($columns as $column) {
                    $subQuery = $subQuery->orWhere($column, 'LIKE', "%{$search}%");
                }
                return $subQuery;
            });
        }
        $data = $data->paginate(5);
        return view('user.order.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::get();
        return view('user.order.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function setPriceStore(Request $request)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            $param = $request->except('_token');
            foreach ($param as $key => $value) {
                $temp = explode('_', $key);
                $productGoodId = $temp[1];
                $customerId = $temp[2];
                $price = PriceCustomerProdManagement::firstOrNew(array('product_goods_id' => $productGoodId, 'customer_id' => $customerId));
                $price->product_goods_id = $productGoodId;
                $price->customer_id = $customerId;
                $price->price =  $value;
                $price->save();
            }
            return redirect()->back()->with(['success' => 'Giá của sản phẩm đối với khách hàng đã được cập nhật!!!']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $message]);
        }
    }
    public function showInstock($id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            $goodReceiptManagement = GoodsReceiptManagement::find($id);
            $productsGoodReceipt = ProductGoodsReceiptManagement::with('product')->where('goods_receipt_id', '=', $goodReceiptManagement->id)->get();
            $customers = Customer::get();
            //
            $listProductPrice = ProductGoodsReceiptManagement::with('prices', 'product', 'prices.customer')->where('goods_receipt_id', '=', $goodReceiptManagement->id)->get();
            return view('user.order.stock-in.show', compact('goodReceiptManagement', 'customers', 'productsGoodReceipt', 'listProductPrice'));
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => $message])->withInput();
        }
    }
    public function stockInIndex(Request $request)
    {
        $data = GoodsReceiptManagement::with('supplier', 'storage')->orderBy('id', 'DESC');
        $data = $data->paginate(5);
        return view('user.order.stock-in.index', compact('data'));
    }

    public function stockInCreate()
    {
        // Get list supplier:
        $suppliers = Supplier::get();
        // Get list ware house:
        $wareHouses = Storage::get();
        // Get list product:
        $products = Product::get();
        return view('user.order.stock-in.create', compact('suppliers', 'wareHouses', 'products'));
    }

    public function exportStockPDF($id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            // Get info:
            $goodReceiptManagement = GoodsReceiptManagement::with('productGood', 'supplier', 'storage', 'productGood.product')->find($id);
            // return view('user.order.stock-in.exportStockPDF', compact('goodReceiptManagement'));
            $pdf = PDF::loadView('components.layouts.exportStockPDF', compact('goodReceiptManagement'));
            return $pdf->download('warehouse_receipt' . date('YmdHms') . '.pdf');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => $message]);
        }
    }

    public function stockInStore(Request $request)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $param = $request->all();
            $goodReceiptManagement = new GoodsReceiptManagement();
            $goodReceiptManagement->goods_receipt_code = $param['order_code'];
            $goodReceiptManagement->supplier_id = $param['order_supplier'];
            $goodReceiptManagement->document = $param['order_contract_no'];
            $goodReceiptManagement->storage_id = $param['order_wh'];
            $goodReceiptManagement->receipt_date = $param['receipt_date'] ? $param['receipt_date'] : now()->format('Y-m-d');
            $goodReceiptManagement->save();
            $idGoodReceipt = $goodReceiptManagement->id;
            // Handel with list product:
            foreach ($param as $name => $value) {
                if (strpos($name, 'order_product_') !== false) {
                    $array = explode('_', $name);
                    // Insert table 
                    $insertProduct = new ProductGoodsReceiptManagement();
                    $insertProduct->goods_receipt_id = $idGoodReceipt;
                    $insertProduct->product_id = $param['order_product_' . $array[2]];
                    $insertProduct->quantity = $param['order_quantity_' . $array[2]];
                    $insertProduct->date_of_manufacture = $param['order_date_manufacture_' . $array[2]];
                    $insertProduct->expiry_date = $param['input_expDate_' . $array[2]];
                    $insertProduct->save();
                    $proId = $insertProduct->id;
                    // Insert table price
                    $product = Product::find($param['order_product_' . $array[2]]);
                    $customers = Customer::get();
                    foreach ($customers as $customer) {
                        $pri = new PriceCustomerProdManagement();
                        $pri->product_goods_id = $proId;
                        $pri->customer_id = $customer->id;
                        $pri->price =  $product->price;
                        $pri->save();
                    }
                }
            }
            //--------------------------
            \DB::commit();
            return redirect()->route('stock-in.index');
        } catch (\Exception $e) {
            dd($e);
            \DB::rollback();
            return back()->withErrors(['msg' => $message])->withInput();
        }
    }
}
