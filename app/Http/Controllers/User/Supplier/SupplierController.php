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
            $data->where(function ($subQuery) use ($columns, $search){
                foreach ($columns as $column) {
                  $subQuery = $subQuery->orWhere($column, 'LIKE', "%{$search}%");
                }
                return $subQuery;
              });
        }
        $data = $data->paginate(5);
        return view('user.supplier.index', compact('data'));
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
        Supplier::create($request->all());

        return redirect()->route('supplier.index');
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
        $data = Supplier::find($id);
        $data->update($request->all());
        $name = $data->name;
        return redirect()->route('supplier.show',$id)->with(['success' => 'Thông tin nhà cung cấp '.$name.' đã được cập nhật!!!']);

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
        return redirect()->back()->with(['success' => 'Đã xoá nhà cung cấp '.$name]);

    }

    public function exportPDF()
    {
        // return "sdsd";
        $suppliers = Supplier::get();
        $rows = [];
        foreach ($suppliers as $key => $value) {
            $rows[] = [
                $key+1,
                $value->supplier_code,
                $value->name,
                $value->address,
                $value->tax_code,
                '<a href="'.route('supplier.show', $value->id).'">Xem</a>'
            ];
        }

        $data=[
            'title'             =>  'DANH SÁCH NHÀ CUNG CẤP',
            'count_record'      =>  'Tổng số nhà cung cấp: '.count($rows),
            'columns'            =>  ['#', 'Mã NCC', 'Tên công ty', 'Địa chỉ', 'Mã số thuế', 'Chi tiết'],
            'rows'  => $rows

        ];

        $pdf = PDF::loadView('components.layouts.exportPDF_list', compact('data'));
        return $pdf->download('suppliers'.date('YmdHms').'.pdf');


    }
}
