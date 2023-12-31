<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order\OrderBuyer;
use App\Models\Order\OrderBuyerProduct;
use App\Models\Order\OrderBuyerStorage;
use App\Models\User;
use App\Models\User\Product;
use App\Models\User\Storage;
use App\Models\User\Supplier;
use Illuminate\Http\Request;
use PDF;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conditions = [];
        if ($request->status != null && $request->status != '') {
            $conditions['status'] = $request->status;
        }
        // dd($conditions);
        $statusColor = config('constants.status_order_buyer_color');
        $statusList = config('constants.status_order_buyer');
        $data = OrderBuyer::where($conditions)->where('status', '<>', '0')->orderBy('id', 'DESC');
        $data = $data->paginate(10);
        return view('user.order.ord_buyer.index', compact('data', 'statusColor', 'statusList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Khởi tạo đơn hàng
        $suppliers = Supplier::get();
        $companyInfo = config('companyInfo');
        $managers = User::role('manager')->get();
        $storages = Storage::get();
        return view('user.order.ord_buyer.create', compact('suppliers', 'companyInfo', 'managers', 'storages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Lưu đơn hàng với status =1
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        // dd($data);
        $order = OrderBuyer::create($data);
        return redirect()->route('order-buyer.step2', $order->id);
    }

    public function create_step1($id)
    {
        //Khởi tạo đơn hàng với status = 1
        //status >= 4 không được cập nhật
        $order = $this->getOrder($id);
        // if ($order->status < 5) {
        //     return redirect()->route('order-buyer.show', $id);
        // }
        $suppliers = Supplier::get();
        $companyInfo = config('companyInfo');
        $managers = User::role('manager')->get();
        $storages = Storage::get();
        return view('user.order.ord_buyer.create_step1', compact('suppliers', 'companyInfo', 'managers', 'order', 'storages'));
    }

    public function store_step1(Request $request, $id)
    {
        //Cập nhật đơn hàng với status = 1
        //status >= 4 không được cập nhật
        $data = $request->all();
        $order = $this->getOrder($id);
        $order = $order->update($data);
        return redirect()->route('order-buyer.step2', $id);
    }

    public function create_step2($id)
    {
        $order = $this->getOrder($id);
        $products = Product::get();
        return view('user.order.ord_buyer.create_step2', compact('order', 'products'));
    }

    public function add_product(Request $request, $id)
    {
        // dd($request->all());
        $data = $request->all();
        $data['order_id'] = $id;
        $data['product_mfg'] = date('Y-m-d');
        $data['product_exp'] = date('Y-m-d');
        OrderBuyerProduct::create($data);
        return redirect()->route('order-buyer.step2', $id);
    }

    public function store_step2(Request $request, $id)
    {
        $order = $this->getOrder($id);
        $order->status = '2';
        $order->save();
        return redirect()->route('order-buyer.step3', $id);
    }

    public function create_step3($id)
    {
        $statusColor = config('constants.status_order_buyer_color');
        $statusList = config('constants.status_order_buyer');
        $order = $this->getOrder($id);
        return view('user.order.ord_buyer.create_step3', compact('order', 'statusColor', 'statusList'));
    }

    public function store_step3(Request $request, $id)
    {

        // $data = $request->all();
        // $order = $this->getOrder($id);
        // $order = $order->update($data);
        // return $this->create_step2($id);
    }


    public function create_step4($id)
    {
        $order = $this->getOrder($id);
        $order->status = '4';
        $order->save();
        return redirect()->route('order-buyer.step3', $id);
    }

    public function create_step6($id)
    {
        //Tạo phiếu nhập kho. Trường hợp ĐH hàng ở trạng thái < 5 (Đã duyệt Đơn đặt hàng hàng) => chuyển về trang show().
        //Nếu trạng thái > 6 thì không được chỉnh sửa (Ẩn button các button đi)
        $order = $this->getOrder($id);
        if ($order->status < 5) {
            return redirect()->route('order-buyer.show', $id);
        }
        $order->status = '6';
        $order->save();
        $warehouse_keeper = User::role('warehouse_keeper')->get();
        return view('user.order.ord_buyer.create_step6', compact('order', 'warehouse_keeper'));
    }

    public function store_step6(Request $request, $id)
    {
        dd($request->all());
        $order = $this->getOrder($id);

        $order->status = '6';
        $order->save();
        return redirect()->route('order-buyer.update.step6', $id);
        // return view('user.order.ord_buyer.create_step6', compact('order', 'warehouse_keeper'));
    }

    public function approve($id)
    {
        $order = $this->getOrder($id);
        $order->status = '5';
        $order->save();
        return redirect()->route('order-buyer.step3', $id);
    }

    public function reject($id)
    {
        $order = $this->getOrder($id);
        $order->status = '3';
        $order->save();
        return redirect()->route('order-buyer.step3', $id);
    }


    private function getOrder($id)
    {
        $data = OrderBuyer::find($id);
            if (!$data) {
                return redirect('/');
            }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->getOrder($id);
        switch ($data->status) {
            case 1:
                return redirect()->route('order-buyer.step2', $id);
                break;
            case 2:
                return redirect()->route('order-buyer.step3', $id);
                break;
            case 3:
                return redirect()->route('order-buyer.step3', $id);
                break;
            case 4:
                return redirect()->route('order-buyer.step3', $id);
                break;
            case 5:
                return redirect()->route('order-buyer.step3', $id);
                break;
            case 6:
                return redirect()->route('order-buyer.step6', $id);
                break;

            default:
                # code...
                break;
        }
    }


    public function purchaseOrderExport($id)
    {
        try {
            $data = $this->getOrder($id);
            $pdf = PDF::loadView('user.order.ord_buyer.order-export', compact('data'));
            return $pdf->download($data->code .'_'. date('YmdHms') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function order_upload(Request $request, $id)
    {
        $file = $request->file('order_file');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);
        $order = $this->getOrder($id);
        $order->order_file = $fileName;
        $order->save();

        return redirect()->route('order-buyer.step3', $id)->with(['success' => "Tải đơn đặt thành công!"])->withInput();
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
}
