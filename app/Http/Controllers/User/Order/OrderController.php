<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Instock\StoreInstockRequest;
use App\Http\Requests\User\Instock\UpdateInstockRequest;
use App\Http\Requests\User\Order\StoreOrderRequest;
use App\Http\Requests\User\Order\UpdateOrderRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\User\Order;
use App\Models\User\OrderDetail;
use App\Models\User\Customer;
use App\Models\User\Supplier;
use App\Models\User\Product;
use App\Models\User\Storage;
use App\Models\User\GoodsReceiptManagement;
use App\Models\User\ProductGoodsReceiptManagement;
use App\Models\User\PriceCustomerProdManagement;
use App\Models\User\StorageProduct;
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
        $data = Order::with('customer')->orderBy('id', 'DESC');
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
        $paymentMethodList = config('constants.payment_method_list');
        $statusList = config('constants.status_receipt_list');
        return view('user.order.index', compact('data', 'paymentMethodList', 'statusList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::get();
        // Get info ware-house:
        $wareHouses = Storage::get();
        // Get all user:
        $dataUser = User::with('roles')->orderBy('id', 'DESC')->get();
        // Get payment method list
        $paymentMethodList = config('constants.payment_method_list');
        $statusList = config('constants.status_receipt_list');
        // Get lst product:
        $products = Product::get();
        return view('user.order.create', compact('customers', 'wareHouses', 'dataUser', 'products', 'paymentMethodList', 'statusList'));
    }

    public function getProductBasedWh(Request $request)
    {
        $param = $request->all();
        $whId = $param['wh_id'];
        $customerId = $param['cus_id'];
        $data = Storage::with('storage_product', 'storage_product.product')->find($whId);
        $listProd = [];
        if ($data) {
            $temp = $data->toArray();
            foreach ($temp['storage_product'] as $no => $detail) {
                $quantityReal = $detail['quantity_plus'] - $detail['quantity_mins'];
                if ($quantityReal > 0) {
                    // Get price 
                    $priceInfo = Product::with([
                        'price_customer' => function ($query) use ($detail, $customerId) {
                            $query->with('customer')->where(array('product_id' => $detail['product_id'], 'customer_id' => $customerId))->first();
                        }
                    ])->find($detail['product_id']);
                    if(count($priceInfo->price_customer) > 0) {
                        $price = $priceInfo->price_customer[0]['price'];
                    }else {
                        $price = 0;
                    }
                    
                    $listProd[$detail['product_id']] = array(
                        'real_quantity' => $quantityReal,
                        'price' => $price,
                        'name' => $detail['product']['name']
                    );
                }
            }
        }
        return response()->json(['status_respone' => true, 'list_product' => $listProd]);
    }

    public function showOrder()
    {

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $param = $request->all();
            $order = new Order();
            $order->order_code = $param['order_code'];
            $order->customer_id = $param['customer_id'];
            $order->payment_method = $param['payment_method'];
            $order->document = $param['order_contract_no'];
            $order->storage_id = $param['order_wh'];
            $order->receive_info = $param['receive_info'];
            $order->receive_cont = $param['receive_cont'];
            $order->delivery_date = $param['delivery_date'];
            $order->receive_user = $param['receive_user'];
            $order->wh_user = $param['wh_user'];
            $order->sales_user = $param['sales_user'];
            $order->order_status = $param['order_status'];
            $order->approval_user = $param['approval_user'];
            $order->save();
            $orderId = $order->id;
            // Handel with list product:
            $arrayProduct = array();
            $isCheckProduct = false;
            foreach ($param as $name => $value) {
                if (strpos($name, 'order_product_') !== false) {
                    $isCheckProduct = true;
                    $array = explode('_', $name);
                    if (in_array($param['order_product_' . $array[2]], $arrayProduct)) {
                        $message = 'Sản phẩm trong đơn hàng không được trùng nhau.';
                        throw new \Exception($message);
                    }

                    if ($param['order_quantity_' . $array[2]] == '') {
                        $message = 'Số lượng của sản phẩm là bắt buộc.';
                        throw new \Exception($message);
                    }

                    if (!is_numeric($param['order_quantity_' . $array[2]])) {
                        $message = 'Số lượng của sản phẩm là dạng số.';
                        throw new \Exception($message);
                    }
                    $getPriceT = explode('_', $param['order_product_' . $array[2]]);

                    // Kiểm tra giới hạn mua hàng:
                    $t = Storage::
                        with([
                            'storage_product' => function ($query) use ($getPriceT) {
                                $query
                                    ->where('product_id', '=', $getPriceT[0])->first();
                            }
                        ])->where(array('id' => $param['order_wh']))->get()->toArray();
                    $maxLimit = 0;
                    if ($t) {
                        $maxLimit = $t[0]['storage_product'][0]['quantity_plus'] - $t[0]['storage_product'][0]['quantity_mins'];
                    }
                    if ($param['order_quantity_' . $array[2]] > $maxLimit) {
                        $message = 'Số lượng vượt quá giới hạn trong kho.';
                        throw new \Exception($message);
                    }
                    array_push($arrayProduct, $param['order_product_' . $array[2]]);
                    // Insert table 
                    $orderDetail = new OrderDetail();
                    $orderDetail->order_id = $orderId;
                    $orderDetail->product_id = $getPriceT[0];
                    $orderDetail->quantity = $param['order_quantity_' . $array[2]];
                    $orderDetail->price = $getPriceT[1];
                    $orderDetail->note_product = $param['note_product_' . $array[2]];
                    $orderDetail->save();
                    // Update table storage:
                    $stoStaProduct = StorageProduct::firstOrNew(array('storage_id' => $param['order_wh'], 'product_id' => $getPriceT[0]));
                    if ($stoStaProduct->exists) {
                        $stoStaProduct->quantity_mins = $stoStaProduct->quantity_mins + $param['order_quantity_' . $array[2]];
                        $stoStaProduct->save();
                    }
                }
            }

            if (!$isCheckProduct) {
                $message = 'Vui lòng chọn kho hàng có sản phẩm.';
                throw new \Exception($message);
            }
            //--------------------------
            \DB::commit();
            return redirect()->route('order.index')->with(['success' => 'Đơn bán đã được tạo thành công.']);
        } catch (\Exception $e) {
            \DB::rollback();
            // return back()->withErrors(['msg' => $message])->withInput();
            return redirect()->back()->with(['error' => $message])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            $order = Order::with('storage', 'approvalUser', 'customer', 'receiveUser', 'whUser', 'saleUser', 'order_detail', 'order_detail.product')->find($id);
            if (!$order) {
                $message = 'Đơn hàng không tồn tại.';
                return redirect()->route('order.index')->with(['error' => $message]);
            }

            $statusList = config('constants.status_receipt_list');
            $paymentMethodList = config('constants.payment_method_list');
            return view('user.order.show', compact('order', 'statusList', 'paymentMethodList'));
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => $message])->withInput();
        }
    }

    public function exportDeliveryPDF($id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            // Get info:
            $order = Order::with('storage', 'approvalUser', 'customer', 'receiveUser', 'whUser', 'saleUser', 'order_detail', 'order_detail.product')->find($id);
            $statusList = config('constants.status_receipt_list');
            // return view('user.order.stock-in.exportStockPDF', compact('order', 'statusList'));
            $pdf = PDF::loadView('components.layouts.deliveryExportPDF', compact('order', 'statusList'));
            return $pdf->download('order_delivery' . date('YmdHms') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $message]);
        }
    }

    public function exportListDeliveryPDF()
    {
        $paymentMethodList = config('constants.payment_method_list');
        $statusList = config('constants.status_receipt_list');
        $data = Order::with('customer', 'storage')->orderBy('id', 'DESC')->get();
        $rows = [];
        foreach ($data as $key => $value) {
            $rows[] = [
                $key + 1,
                $value->order_code,
                $value->customer->name,
                $value->storage->name,
                $value->delivery_date ? $value->delivery_date->format('d-m-Y') : '',
                $value->payment_method ? $paymentMethodList[$value->payment_method] : '',
                $value->order_status ? $statusList[$value->order_status] : '',
                '<a href="' . route('order.show', $value->id) . '">Xem</a>'
            ];
        }

        $data = [
            'title' => 'DANH SÁCH ĐƠN MUA (XUẤT KHO)',
            'count_record' => 'Tổng số đơn xuất: ' . count($rows),
            'columns' => ['#', 'Mã xuất kho', 'Khách hàng', 'Kho hàng', 'Ngày tạo đơn', 'Hình thức thanh toán', 'Trạng thái', 'Chi tiết'],
            'rows' => $rows

        ];

        $pdf = PDF::loadView('components.layouts.exportPDF_list', compact('data'));
        return $pdf->download('export_order' . date('YmdHms') . '.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            $customers = Customer::get();
            // Get info ware-house:
            // Get list supplier:
            $suppliers = Supplier::get();
            // Get list ware house:
            $wareHouses = Storage::get();
            // Get list product:
            $products = Product::get();
            // Get info warehouse receipt:
            $order = Order::with('storage', 'approvalUser', 'customer', 'receiveUser', 'whUser', 'saleUser', 'order_detail', 'order_detail.product')->find($id);
            if ($order == null) {
                $message = 'Đơn hàng không tồn tại.';
                throw new \Exception($message);
            }

            if ($order->order_status == 3) {
                $message = 'Đơn hàng đã được duyệt. Không cho phép update.';
                throw new \Exception($message);
            }
            //Get status
            $statusList = config('constants.status_receipt_list');
            $paymentMethodList = config('constants.payment_method_list');
            // Get all user
            $dataUser = User::with('roles')->orderBy('id', 'DESC')->get();
            // Get list product:
            $productL = getProductBasedWhHelper($order->storage_id, $order->customer_id);
            // Return
            return view('user.order.edit', compact('customers', 'wareHouses', 'order', 'dataUser', 'paymentMethodList', 'statusList', 'productL'));
        } catch (\Exception $e) {
            return redirect()->route('order.show', $id)->with(['error' => $message]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateOrderRequest $request)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $param = $request->all();
            $order = Order::find($id);
            // Check status order when edit:
            if ($order->order_status == 3) {
                $message = 'Đơn hàng đã được duyệt. Không cho phép update.';
                return redirect()->route('order.show', $id)->with(['error' => $message]);
            }
            // Update info order:
            $orderUpdate = Order::firstOrNew(array('id' => $id));
            $orderUpdate->order_code = $param['order_code'];
            $orderUpdate->customer_id = $param['customer_id'];
            $orderUpdate->payment_method = $param['payment_method'];
            $orderUpdate->document = $param['order_contract_no'];
            $orderUpdate->storage_id = $param['order_wh'];
            $orderUpdate->receive_info = $param['receive_info'];
            $orderUpdate->receive_cont = $param['receive_cont'];
            $orderUpdate->delivery_date = $param['delivery_date'];
            $orderUpdate->receive_user = $param['receive_user'];
            $orderUpdate->wh_user = $param['wh_user'];
            $orderUpdate->sales_user = $param['sales_user'];
            $orderUpdate->order_status = $param['order_status'];
            $orderUpdate->approval_user = $param['approval_user'];
            $orderUpdate->save();
            // Handel with list product:
            $arrayProduct = array();
            $isCheckProduct = false;
            //Lưu danh sách sp update
            $arrayProductUpdate = array();
            foreach ($param as $name => $value) {
                if (strpos($name, 'order_product_') !== false) {
                    $isCheckProduct = true;
                    $array = explode('_', $name);
                    if (in_array($param['order_product_' . $array[2]], $arrayProduct)) {
                        $message = 'Sản phẩm trong đơn hàng không được trùng nhau.';
                        throw new \Exception($message);
                    }

                    if ($param['order_quantity_' . $array[2]] == '') {
                        $message = 'Số lượng của sản phẩm là bắt buộc.';
                        throw new \Exception($message);
                    }


                    if (!is_numeric($param['order_quantity_' . $array[2]])) {
                        $message = 'Số lượng của sản phẩm là dạng số.';
                        throw new \Exception($message);
                    }

                    if ($param['order_quantity_' . $array[2]] <= 0) {
                        $message = 'Số lượng của sản phẩm phải lớn hơn 0';
                        throw new \Exception($message);
                    }

                    $getPriceT = explode('_', $param['order_product_' . $array[2]]);
                    //
                    $temQuantity = Storage::
                        with([
                            'storage_product' => function ($query) use ($getPriceT) {
                                $query
                                    ->where('product_id', '=', $getPriceT[0])->first();
                            }
                        ])->where(array('id' => $param['order_wh']))->get()->toArray();
                    $maxLimit = 0;
                    if ($temQuantity) {
                        $maxLimit = $temQuantity[0]['storage_product'][0]['quantity_plus'] - $temQuantity[0]['storage_product'][0]['quantity_mins'];
                    }
                    $orderDetail = OrderDetail::firstOrNew(array('order_id' => $id, 'product_id' => $param['order_product_' . $array[2]]));
                    // Nếu sp đã tồn tại sẵn:
                    if ($orderDetail->exists) {
                        $oldQuantity = $orderDetail->quantity;
                        $diffQuantity = $oldQuantity - $param['order_quantity_' . $array[2]];
                        if ($diffQuantity >= 0) {
                            //Số lượng giảm or không đổi:
                        } else {
                            //Tăng số lượng:
                            //Kiểm tra giới hạn trong kho:
                            if ($maxLimit + $diffQuantity < 0) {
                                $message = 'Số lượng vượt quá giới hạn trong kho.';
                                throw new \Exception($message);
                            }
                        }
                        // Update lại số lượng:
                        $orderDetail->quantity = $orderDetail->quantity - $diffQuantity;
                        $orderDetail->save();
                    } else {
                        // Trường hợp chưa tồn tại sản phẩm:
                        if ($param['order_quantity_' . $array[2]] > $maxLimit) {
                            $message = 'Số lượng vượt quá giới hạn trong kho.';
                            throw new \Exception($message);
                        }
                        // ITạo sản phẩm mới:
                        $orderDetailNew = new OrderDetail();
                        $orderDetailNew->order_id = $id;
                        $orderDetailNew->product_id = $getPriceT[0];
                        $orderDetailNew->quantity = $param['order_quantity_' . $array[2]];
                        $orderDetailNew->price = $getPriceT[1];
                        $orderDetailNew->note_product = $param['note_product_' . $array[2]];
                        $orderDetailNew->save();
                        // Update table storage:
                        $diffQuantity = - $param['order_quantity_' . $array[2]];
                       
                    }
                    //Update lại stogare:
                    $stoStaProduct = StorageProduct::firstOrNew(array('storage_id' => $param['order_wh'], 'product_id' => $getPriceT[0]));
                    if ($stoStaProduct->exists) {
                        $stoStaProduct->quantity_mins = $stoStaProduct->quantity_mins - $diffQuantity;
                        $stoStaProduct->save();
                    }
                    array_push($arrayProductUpdate, $getPriceT[0]);
                    array_push($arrayProduct, $param['order_product_' . $array[2]]);
                }
            }
            // Check required sản phẩm:
            if (!$isCheckProduct) {
                $message = 'Vui lòng chọn kho hàng có sản phẩm.';
                throw new \Exception($message);
            }
            // Delete product:
            $prodOlds = OrderDetail::where('order_id', '=', $id)->get();
            foreach ($prodOlds as $prodOld) {
                if (!in_array($prodOld->product_id, $arrayProductUpdate)) {
                    // Update lại số lượng trong kho
                    $stoStaProduct = StorageProduct::firstOrNew(array('storage_id' => $param['order_wh'], 'product_id' => $prodOld->product_id));
                    if ($stoStaProduct->exists) {
                        $stoStaProduct->quantity_mins = $stoStaProduct->quantity_mins - $prodOld->quantity;
                        $stoStaProduct->save();
                    }
                    // remove table order_detail
                    $prodOld->delete();
                }
            }
            // Commit
            \DB::commit();
            return redirect()->route('order.show', $id)->with(['success' => 'Thông tin đơn bán (xuất kho) đã được cập nhật.!!!']);
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with(['error' => $message])->withInput();
        }
    }

    public function notificationOrderPDF($orderId) 
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $message]);
        }
    }
    
    public function exportInvoicePDF($orderId) 
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            $order = Order::with('storage', 'approvalUser', 'customer', 'receiveUser', 'whUser', 'saleUser', 'order_detail', 'order_detail.product', 'order_detail.product.brand')->find($orderId);
            // return view('user.order.stock-in.exportStockPDF', compact('order', 'statusList'));
            // return view('user.order.exportInvoice', compact('order'));
            // $pdf = PDF::loadView('user.order.exportInvoice', compact('order'));
            $pdf = PDF::loadView('components.layouts.exportInvoice', compact('order'));
            return $pdf->download('warehouse_receipt' . date('YmdHms') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $message]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deliveryDelete($id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $order = Order::find($id);
            if ($order->receipt_status == 3) {
                $message = 'Đơn hàng đã được duyệt. Không cho phép xóa.';
                return redirect()->route('stock-in.index')->with(['error' => $message]);
            }
            Order::where(array('id' => $id))->delete();

            $prodList = OrderDetail::where(array('order_id' => $id))->get();
            foreach ($prodList as $detailProd) {
                $detailProd->delete();
                $stoStaProduct = StorageProduct::firstOrNew(array('storage_id' => $order->storage_id, 'product_id' => $detailProd->product_id));
                if ($stoStaProduct->exists) {
                    $stoStaProduct->quantity_mins = $stoStaProduct->quantity_mins - $detailProd->quantity;
                    $stoStaProduct->save();
                }
            }
            \DB::commit();
            return redirect()->back()->with(['success' => 'Thông tin đơn bán (xuất kho) đã được xóa.!!!']);
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with(['error' => $message]);
        }
    }

    /**
     * Set price
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function setPriceStore(Request $request)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            $param = $request->except('_token');
            $goodReceiptManagement = GoodsReceiptManagement::find($param['good_receipt_id']);
            $param = $request->except('_token', 'good_receipt_id');
            if ($goodReceiptManagement == null) {
                $message = 'Đơn hàng không tồn tại.';
                throw new \Exception($message);
            }

            if ($goodReceiptManagement->receipt_status == 3) {
                $message = 'Đơn hàng đã được duyệt. Không cho phép update.';
                throw new \Exception($message);
            }
            foreach ($param as $key => $value) {
                $temp = explode('_', $key);
                $productGoodId = $temp[1];
                $customerId = $temp[2];
                $price = PriceCustomerProdManagement::firstOrNew(array('product_goods_id' => $productGoodId, 'customer_id' => $customerId));
                $price->product_goods_id = $productGoodId;
                $price->customer_id = $customerId;
                $price->price = $value;
                $price->save();
            }
            return redirect()->back()->with(['success' => 'Giá của sản phẩm đối với khách hàng đã được cập nhật!!!']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $message]);
        }
    }

    /**
     * Show in-Stock
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function showInstock($id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            $goodReceiptManagement = GoodsReceiptManagement::with('approvalUser', 'receiveUser', 'whUser', 'saleUser')->find($id);
            if (!$goodReceiptManagement) {
                $message = 'Đơn hàng không tồn tại.';
                return redirect()->route('stock-in.index')->with(['error' => $message]);
            }
            $productsGoodReceipt = ProductGoodsReceiptManagement::with('product')->where('goods_receipt_id', '=', $goodReceiptManagement->id)->get();
            $customers = Customer::get();
            //
            $statusList = config('constants.status_receipt_list');
            return view('user.order.stock-in.show', compact('goodReceiptManagement', 'customers', 'productsGoodReceipt', 'statusList'));
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => $message])->withInput();
        }
    }

    /**
     * stockInIndex
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function stockInIndex(Request $request)
    {
        //Get status
        $statusList = config('constants.status_receipt_list');
        $data = GoodsReceiptManagement::with('supplier', 'storage')->orderBy('id', 'DESC');
        $data = $data->paginate(5);
        return view('user.order.stock-in.index', compact('data', 'statusList'));
    }

    /**
     * Edit warehouse receipt
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function stockInEdit($id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            // Get list supplier:
            $suppliers = Supplier::get();
            // Get list ware house:
            $wareHouses = Storage::get();
            // Get list product:
            $products = Product::get();
            // Get info warehouse receipt:
            $goodReceiptManagement = GoodsReceiptManagement::find($id);
            if ($goodReceiptManagement == null) {
                $message = 'Đơn hàng không tồn tại.';
                throw new \Exception($message);
            }

            if ($goodReceiptManagement->receipt_status == 3) {
                $message = 'Đơn hàng đã được duyệt. Không cho phép update.';
                throw new \Exception($message);
            }
            // Get product of warehouse receipt:
            $productsGoodReceipt = ProductGoodsReceiptManagement::with('product')->where('goods_receipt_id', '=', $goodReceiptManagement->id)->get();
            //Get status
            $statusList = config('constants.status_receipt_list');
            // Get all user
            $dataUser = User::with('roles')->orderBy('id', 'DESC')->get();
            // Return
            return view('user.order.stock-in.edit', compact('goodReceiptManagement', 'suppliers', 'wareHouses', 'products', 'productsGoodReceipt', 'statusList', 'dataUser'));
        } catch (\Exception $e) {
            return redirect()->route('stock-in.price', $id)->with(['error' => $message]);
        }
    }

    /**
     * export list warehouse receipt pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function exportListStockPDF()
    {
        // return "sdsd";
        $data = GoodsReceiptManagement::with('supplier', 'storage')->orderBy('id', 'DESC')->get();

        $rows = [];
        foreach ($data as $key => $value) {
            $rows[] = [
                $key + 1,
                $value->goods_receipt_code,
                $value->supplier->name,
                $value->storage->name,
                $value->receipt_date ? $value->receipt_date->format('d-m-Y') : '',
                $value->status,
                '<a href="' . route('stock-in.price', $value->id) . '">Xem</a>'
            ];
        }

        $data = [
            'title' => 'DANH SÁCH ĐƠN MUA (NHẬP KHO)',
            'count_record' => 'Tổng số đơn mua: ' . count($rows),
            'columns' => ['#', 'Mã Nhập kho', 'Nhà cung cấp	', 'Kho hàng', 'Ngày tạo đơn', 'Trạng thái', 'Chi tiết'],
            'rows' => $rows

        ];

        $pdf = PDF::loadView('components.layouts.exportPDF_list', compact('data'));
        return $pdf->download('warehouse_receipt' . date('YmdHms') . '.pdf');
    }

    /**
     * Update warehouse receipt
     *
     * @param  $id
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function stockInUpdate($id, UpdateInstockRequest $request)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $param = $request->all();
            $goodReceiptManagementFind = GoodsReceiptManagement::find($id);
            if ($goodReceiptManagementFind->receipt_status == 3) {
                $message = 'Đơn hàng đã được duyệt. Không cho phép update.';
                return redirect()->route('stock-in.price', $id)->with(['error' => $message]);
            }
            // Check and update info warehouse receipt:
            $goodReceiptManagement = GoodsReceiptManagement::firstOrNew(array('id' => $id));
            $goodReceiptManagement->goods_receipt_code = $param['order_code'];
            $goodReceiptManagement->supplier_id = $param['order_supplier'];
            $goodReceiptManagement->document = $param['order_contract_no'];
            $goodReceiptManagement->storage_id = $param['order_wh'];
            $goodReceiptManagement->receipt_date = $param['receipt_date'] ? $param['receipt_date'] : now()->format('d-m-Y');
            $goodReceiptManagement->receive_cont = $param['receive_cont'];
            $goodReceiptManagement->receive_info = $param['receive_info'];
            $goodReceiptManagement->receipt_status = $param['receipt_status'];
            $goodReceiptManagement->sales_user = $param['sales_user'];
            $goodReceiptManagement->wh_user = $param['wh_user'];
            $goodReceiptManagement->receive_user = $param['receive_user'];
            $goodReceiptManagement->approval_user = $param['approval_user'];
            $goodReceiptManagement->save();

            // Handel with list product
            $arrayProductUpdate = array();
            // Handel with list product:
            $arrayProduct = array();
            foreach ($param as $name => $value) {
                if (strpos($name, 'order_product_') !== false) {
                    $array = explode('_', $name);
                    if (in_array($param['order_product_' . $array[2]], $arrayProduct)) {
                        $message = 'Sản phẩm trong đơn hàng không được trùng nhau.';
                        throw new \Exception($message);
                    }
                    if ($param['order_quantity_' . $array[2]] == '') {
                        $message = 'Số lượng của sản phẩm là bắt buộc.';
                        throw new \Exception($message);
                    }
                    array_push($arrayProduct, $param['order_product_' . $array[2]]);

                    array_push($arrayProductUpdate, $param['order_product_' . $array[2]]);
                    $insertProduct = ProductGoodsReceiptManagement::firstOrNew(array('goods_receipt_id' => $id, 'product_id' => $param['order_product_' . $array[2]]));
                    if ($insertProduct->exists) {
                        //Exist
                        $insertProduct->goods_receipt_id = $id;
                        $insertProduct->product_id = $param['order_product_' . $array[2]];
                        $insertProduct->quantity = $param['order_quantity_' . $array[2]];
                        $insertProduct->date_of_manufacture = $param['order_date_manufacture_' . $array[2]];
                        $insertProduct->expiry_date = $param['input_expDate_' . $array[2]];
                        $insertProduct->note_product = $param['note_product_' . $array[2]];
                        $insertProduct->save();
                    } else {
                        $insertProduct = new ProductGoodsReceiptManagement();
                        $insertProduct->goods_receipt_id = $id;
                        $insertProduct->product_id = $param['order_product_' . $array[2]];
                        $insertProduct->quantity = $param['order_quantity_' . $array[2]];
                        $insertProduct->date_of_manufacture = $param['order_date_manufacture_' . $array[2]];
                        $insertProduct->expiry_date = $param['input_expDate_' . $array[2]];
                        $insertProduct->note_product = $param['note_product_' . $array[2]];
                        $insertProduct->save();
                        $proId = $insertProduct->id;
                        // Insert table price
                        $product = Product::find($param['order_product_' . $array[2]]);
                        $customers = Customer::get();
                        // foreach ($customers as $customer) {
                        //     $pri = new PriceCustomerProdManagement();
                        //     $pri->product_goods_id = $proId;
                        //     $pri->customer_id = $customer->id;
                        //     $pri->price = $product->price;
                        //     $pri->save();
                        // }
                    }
                }
            }
            // Delete product:
            $prodOlds = ProductGoodsReceiptManagement::where('goods_receipt_id', '=', $id)->get();
            foreach ($prodOlds as $prodOld) {
                if (!in_array($prodOld->product_id, $arrayProductUpdate)) {
                    // remove table product_goods_receipt_management
                    $prodOld->delete();
                    // Remove table price_customer_prod_management
                    // PriceCustomerProdManagement::where(array('product_goods_id' => $prodOld->id))->delete();
                }
            }

            // Handle with status "đã duyệt xong"
            if ($goodReceiptManagement->receipt_status == 3) {
                foreach ($prodOlds as $prodOld) {
                    // check exist product in storage
                    $stoStaProduct = StorageProduct::firstOrNew(array('storage_id' => $goodReceiptManagement->storage_id, 'product_id' => $prodOld->product_id));
                    if ($stoStaProduct->exists) {
                        $stoStaProduct->quantity_plus = $stoStaProduct->quantity_plus + $prodOld->quantity;
                        $stoStaProduct->save();
                    } else {
                        $stoStaProduct = new StorageProduct();
                        $stoStaProduct->storage_id = $goodReceiptManagement->storage_id;
                        $stoStaProduct->product_id = $prodOld->product_id;
                        $stoStaProduct->quantity_plus = $prodOld->quantity;
                        $stoStaProduct->save();
                    }

                }
            }

            // Commit
            \DB::commit();
            return redirect()->route('stock-in.price', $id)->with(['success' => 'Thông tin đơn mua (nhập kho) đã được cập nhật.!!!']);
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with(['error' => $message])->withInput();
            // return back()->withErrors(['msg' => $message])->withInput();
        }
    }


    /**
     * Create warehouse receipt
     *
     * @return \Illuminate\Http\Response
     */
    public function stockInCreate()
    {
        // Get list supplier:
        $suppliers = Supplier::get();
        // Get list ware house:
        $wareHouses = Storage::get();
        // Get list product:
        $products = Product::get();
        // Get list status
        $statusList = config('constants.status_receipt_list');
        // Get all user
        // $data = User::with('roles')->orderBy('id', 'DESC')->get();
        $dataUser = User::with('roles')->orderBy('id', 'DESC')->get();
        return view('user.order.stock-in.create', compact('suppliers', 'wareHouses', 'products', 'dataUser', 'statusList'));
    }

    /**
     * Export warehouse receipt pdf
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function exportStockPDF($id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            // Get info:
            $goodReceiptManagement = GoodsReceiptManagement::with('productGood', 'supplier', 'storage', 'productGood.product', 'approvalUser', 'receiveUser', 'whUser', 'saleUser')->find($id);
            $statusList = config('constants.status_receipt_list');
            // return view('user.order.stock-in.exportStockPDF', compact('goodReceiptManagement'));
            $pdf = PDF::loadView('components.layouts.exportStockPDF', compact('goodReceiptManagement', 'statusList'));
            return $pdf->download('warehouse_receipt' . date('YmdHms') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $message]);
        }
    }

    public function stockInDelete($idGoodReceipt)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $goodReceiptManagement = GoodsReceiptManagement::find($idGoodReceipt);
            if ($goodReceiptManagement->receipt_status == 3) {
                $message = 'Đơn hàng đã được duyệt. Không cho phép xóa.';
                return redirect()->route('stock-in.index')->with(['error' => $message]);
            }
            GoodsReceiptManagement::where(array('id' => $idGoodReceipt))->delete();

            $prodList = ProductGoodsReceiptManagement::where(array('goods_receipt_id' => $idGoodReceipt))->get();
            foreach ($prodList as $detailProd) {
                $detailProd->delete();
                // PriceCustomerProdManagement::where(array('product_goods_id' => $detailProd->id))->delete();
            }
            \DB::commit();
            return redirect()->back()->with(['success' => 'Thông tin đơn mua (nhập kho) đã được xóa.!!!']);
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with(['error' => $message]);
        }
    }
    public function stockInStore(StoreInstockRequest $request)
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
            $goodReceiptManagement->receipt_date = $param['receipt_date'] ? $param['receipt_date'] : now()->format('d-m-Y');
            $goodReceiptManagement->receive_cont = $param['receive_cont'];
            $goodReceiptManagement->receive_info = $param['receive_info'];
            $goodReceiptManagement->receipt_status = $param['receipt_status'];
            $goodReceiptManagement->sales_user = $param['sales_user'];
            $goodReceiptManagement->wh_user = $param['wh_user'];
            $goodReceiptManagement->receive_user = $param['receive_user'];
            $goodReceiptManagement->approval_user = $param['approval_user'];
            $goodReceiptManagement->save();
            $idGoodReceipt = $goodReceiptManagement->id;
            // Handel with list product:
            $arrayProduct = array();
            foreach ($param as $name => $value) {
                if (strpos($name, 'order_product_') !== false) {
                    $array = explode('_', $name);
                    if (in_array($param['order_product_' . $array[2]], $arrayProduct)) {
                        $message = 'Sản phẩm trong đơn hàng không được trùng nhau.';
                        throw new \Exception($message);
                    }

                    if ($param['order_quantity_' . $array[2]] == '') {
                        $message = 'Số lượng của sản phẩm là bắt buộc.';
                        throw new \Exception($message);
                    }

                    if (!is_numeric($param['order_quantity_' . $array[2]])) {
                        $message = 'Số lượng của sản phẩm là dạng số.';
                        throw new \Exception($message);
                    }
                    array_push($arrayProduct, $param['order_product_' . $array[2]]);

                    // Insert table 
                    $insertProduct = new ProductGoodsReceiptManagement();
                    $insertProduct->goods_receipt_id = $idGoodReceipt;
                    $insertProduct->product_id = $param['order_product_' . $array[2]];
                    $insertProduct->quantity = $param['order_quantity_' . $array[2]];
                    $insertProduct->date_of_manufacture = $param['order_date_manufacture_' . $array[2]];
                    $insertProduct->expiry_date = $param['input_expDate_' . $array[2]];
                    $insertProduct->note_product = $param['note_product_' . $array[2]];
                    $insertProduct->save();
                    $proId = $insertProduct->id;
                    // Insert table price
                    // $product = Product::find($param['order_product_' . $array[2]]);
                    // $customers = Customer::get();
                    // foreach ($customers as $customer) {
                    //     $pri = new PriceCustomerProdManagement();
                    //     $pri->product_goods_id = $proId;
                    //     $pri->customer_id = $customer->id;
                    //     $pri->price = $product->price;
                    //     $pri->save();
                    // }
                }
            }
            //--------------------------
            \DB::commit();
            return redirect()->route('stock-in.index')->with(['success' => 'Đơn hàng mới đã được tạo thành công.']);
        } catch (\Exception $e) {
            \DB::rollback();
            // return back()->withErrors(['msg' => $message])->withInput();
            return redirect()->back()->with(['error' => $message])->withInput();
        }
    }
}