<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\OrderBuyer\OrderBuyerStoreRequest;
use App\Models\User;
use App\Models\User\OrderBuyer;
use App\Models\User\Product;
use App\Models\User\Storage;
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
        $data = OrderBuyer::with('supplier', 'storage')->where('status','<','5')->orderBy('id', 'DESC');
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
        $dataUser = User::with('roles')->orderBy('id', 'DESC')->get();
        return view('user.order.order-buyer.create', compact('suppliers', 'wareHouses', 'products', 'dataUser', 'statusList', 'companyInfo'));
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
            $data['created_by']     =   Auth::user()->id;
            $data['assignee']     =   Auth::user()->id;
            $order = OrderBuyer::create($data);
            DB::commit();
            return redirect()->route('order-buyer.show', $order->id);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    // public function createStep2()
    // {
    //     $suppliers = Supplier::get();
    //     $wareHouses = Storage::get();
    //     $products = Product::get();
    //     $statusList = config('constants.status_receipt_list');
    //     $companyInfo= config('companyInfo');
    //     $dataUser = User::with('roles')->orderBy('id', 'DESC')->get();
    //     return view('user.order.order-buyer.create', compact('suppliers', 'wareHouses', 'products', 'dataUser', 'statusList', 'companyInfo'));
    // }

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


            // if ($data->status === 1) {
            //     return redirect()->route('order-buyer.show', $id);
            // }

            // $goodReceiptManagement = GoodsReceiptManagement::with('approvalUser', 'receiveUser', 'whUser', 'saleUser')->find($id);
            // if (!$goodReceiptManagement) {
            //     $message = 'Đơn hàng không tồn tại.';
            //     return redirect()->route('stock-in.index')->with(['error' => $message]);
            // }
            // $productsGoodReceipt = ProductGoodsReceiptManagement::with('product')->where('goods_receipt_id', '=', $goodReceiptManagement->id)->get();
            // $customers = Customer::get();
            // //
            // $statusList = config('constants.status_receipt_list');
            DB::commit();
            return view('user.order.order-buyer.show', compact('data', 'statusList', 'order_info'));
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
            // dd($order_info);
            // Get info:
            // $goodReceiptManagement = GoodsReceiptManagement::with('productGood', 'supplier', 'storage', 'productGood.product', 'approvalUser', 'receiveUser', 'whUser', 'saleUser')->find($id);
            // $statusList = config('constants.status_receipt_list');
            // // return view('user.order.stock-in.exportStockPDF', compact('goodReceiptManagement'));
            $pdf = PDF::loadView('components.layouts.purchase-order-export', compact('data','order_info'));
            return $pdf->download('purchase-order-export' . date('YmdHms') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }


}
