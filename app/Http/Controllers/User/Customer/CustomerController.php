<?php

namespace App\Http\Controllers\User\Customer;

use App\Http\Controllers\Controller;
use App\Models\User\PriceCustomerProdManagement;
use App\Models\User\Product;
use Illuminate\Http\Request;
use App\Models\User\Customer;
use PDF;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $customers = Customer::orderBy('id', 'DESC');

        if (isset($request->search)) {
            $search = $request->search;
            $columns = ['name', 'code', 'tax_code', 'address', 'contact', 'tax'];
            $customers->where(function ($subQuery) use ($columns, $search) {
                foreach ($columns as $column) {
                    $subQuery = $subQuery->orWhere($column, 'LIKE', "%{$search}%");
                }
                return $subQuery;
            });
        }
        $customers = $customers->paginate(5);
        return view('user.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $customer = Customer::create($request->all());
            if ($customer) {
                $customerId = $customer->id;
                // Set price for customer:
                $products = Product::get();
                foreach ($products as $product) {
                    $pri = new PriceCustomerProdManagement();
                    $pri->product_id = $product->id;
                    $pri->customer_id = $customerId;
                    $pri->price = $product->price;
                    $pri->save();
                }
            }
            \DB::commit();
            return redirect()->route('customer.index') > with(['success' => 'Khách hàng đã được tạo thành công.']);
        } catch (\Exception $e) {
            \DB::rollback();
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
        $data = Customer::find($id);
        return view('user.customer.edit', compact('data'));
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
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            //Update customer:
            $customer = Customer::find($id);
            $customer->update($request->all());
            $name = $customer->name;
            //Update price:
            $products = Product::get();
            foreach ($products as $product) {
                $price = PriceCustomerProdManagement::firstOrNew(array('product_id' => $product->id, 'customer_id' => $customer->id));
                if(!$price->false) {
                    $pri = new PriceCustomerProdManagement();
                    $pri->product_id = $product->id;
                    $pri->customer_id = $customer->id;
                    $pri->price = $product->price;
                    $pri->save();
                }
            }
            return redirect()->back()->with(['success' => 'Thông tin khách hàng ' . $name . ' đã được cập nhật!!!']);
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
    public function destroy($id)
    {
        $data = Customer::find($id);
        $name = $data->name;
        $data->delete();
        return redirect()->back()->with(['success' => 'Đã xoá khách hàng ' . $name]);
    }

    public function exportPDF()
    {
        // return "sdsd";
        $customers = Customer::get();
        $rows = [];
        foreach ($customers as $key => $value) {
            $rows[] = [
                $key + 1,
                $value->code,
                $value->name,
                $value->address,
                $value->tax,
                $value->contact['email'] . "</br>" . $value->contact['phone'],
                '<a href="' . route('supplier.show', $value->id) . '">Xem</a>'
            ];
        }

        $data = [
            'title' => 'DANH SÁCH NHÀ CUNG CẤP',
            'count_record' => 'Tổng số nhà cung cấp: ' . count($rows),
            'columns' => ['#', 'Mã KH', 'Tên', 'Địa chỉ', 'Mã số thuế', 'Liên hệ', 'Chi tiết'],
            'rows' => $rows

        ];

        $pdf = PDF::loadView('components.layouts.exportPDF_list', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->download('customers' . date('YmdHms') . '.pdf');


    }
}