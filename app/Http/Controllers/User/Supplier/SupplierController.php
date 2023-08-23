<?php

namespace App\Http\Controllers\User\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Supplier;
use ViKon\Diff\Diff;
use App\Models\User\SupplierHistory;
use PDF;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $diff = Diff::compare("hello", "hello");
        // return $diff->toHTML();
        $data = Supplier::orderBy('id', 'DESC');
        if (isset($request->search)) {
            $search = $request->search;
            $columns = ['name', 'address', 'tax_code'];
            $data->where(function ($subQuery) use ($columns, $search) {
                foreach ($columns as $column) {
                    $subQuery = $subQuery->orWhere($column, 'LIKE', "%{$search}%");
                }
                return $subQuery;
            });
        }
        $data = $data->paginate(5);
        return view('user.supplier.index', compact('data'));
    }

    public function getSupplierHis($id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            $data = Supplier::find($id);
            $history = SupplierHistory::with('user_updated', 'user_created')->where(array('supplier_id' => $id));
            if ($history->count() == 0) {
                return view('user.supplier.show', compact('data'));
            }
            $history = $history->paginate(5);
            return view('user.supplier.listHistory', compact('data', 'history'));
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with(['error' => $message])->withInput();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.supplier.create');
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
            $supplier = Supplier::create($request->all());
            // --------------------------
            $his = new SupplierHistory();
            $his->supplier_id = $supplier->id;
            $his->name = $supplier->name;
            $his->address = $supplier->address;
            $his->tax_code = $supplier->tax_code;
            $his->supplier_code = $supplier->supplier_code;
            $his->created_by = \Auth::user()->id;
            // $his->updated_by = \Auth::user()->id;
            $his->save();
            \DB::commit();
            return redirect()->route('supplier.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
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
        $data = Supplier::find($id);
        if (!$data) {
            abort(404);
        }
        return view('user.supplier.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Supplier::find($id);
        return view('user.supplier.edit', compact('data'));
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
        \DB::beginTransaction();
        try {
            $data = Supplier::find($id);
            $data->update($request->all());
            $name = $data->name;
            // --------------------------
            $his = new SupplierHistory();
            $his->supplier_id = $data->id;
            $his->name = $data->name;
            $his->address = $data->address;
            $his->tax_code = $data->tax_code;
            $his->supplier_code = $data->supplier_code;
            $his->updated_by = \Auth::user()->id;
            // $his->updated_by = \Auth::user()->id;
            $his->save();
            \DB::commit();
            return redirect()->route('supplier.show', $id)->with(['success' => 'Thông tin nhà cung cấp ' . $name . ' đã được cập nhật!!!']);
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with(['error' => $message])->withInput();
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
        $data = Supplier::find($id);
        $name = $data->name;
        $data->delete();
        return redirect()->back()->with(['success' => 'Đã xoá nhà cung cấp ' . $name]);

    }

    public function exportPDF()
    {
        // return "sdsd";
        $suppliers = Supplier::get();
        $rows = [];
        foreach ($suppliers as $key => $value) {
            $rows[] = [
                $key + 1,
                $value->supplier_code,
                $value->name,
                $value->address,
                $value->tax_code,
                '<a href="' . route('supplier.show', $value->id) . '">Xem</a>'
            ];
        }

        $data = [
            'title' => 'DANH SÁCH NHÀ CUNG CẤP',
            'count_record' => 'Tổng số nhà cung cấp: ' . count($rows),
            'columns' => ['#', 'Mã NCC', 'Tên công ty', 'Địa chỉ', 'Mã số thuế', 'Chi tiết'],
            'rows' => $rows

        ];

        $pdf = PDF::loadView('components.layouts.exportPDF_list', compact('data'));
        return $pdf->download('suppliers' . date('YmdHms') . '.pdf');


    }
}