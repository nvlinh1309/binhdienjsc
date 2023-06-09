<?php

namespace App\Http\Controllers\User\Brand;

use App\Http\Controllers\Controller;
use App\Models\User\Brand;
use App\Models\User\Supplier;
use Illuminate\Http\Request;
use PDF;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Brand::with('suppliers')->orderBy('id', 'DESC');
        if (isset($request->search)) {
            $search = $request->search;
            $columns = ['name'];
            $data->where(function ($subQuery) use ($columns, $search){
                foreach ($columns as $column) {
                  $subQuery = $subQuery->orWhere($column, 'LIKE', "%{$search}%");
                }
                return $subQuery;
              });
        }
        $data = $data->paginate(5);
        return view('user.brand.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::get();
        return view('user.brand.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplier_ids = $request->supplier_id;
        $brand = Brand::create([
                'name' => $request->name
        ]);
        $brand->suppliers()->attach($supplier_ids);
        return redirect()->route('brand.index')->with(['success' => 'Thương hiệu '.$request->name.' đã được thêm mới!!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Brand::with('suppliers')->find($id);
        if (!$data) {
            abort(404);
        }
        return view('user.brand.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Brand::with('suppliers')->find($id);
        $suppliers = Supplier::get();
        return view('user.brand.edit', compact('data', 'suppliers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $supplier_ids = $request->supplier_id;
        $data = Brand::find($id);
        $data->update($request->all());
        $data->suppliers()->sync($supplier_ids);
        $name = $data->name;
        return redirect()->route('brand.show', $id)->with(['success' => 'Thông tin thương hiệu '.$name.' đã được cập nhật!!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Brand::find($id);
        $name = $data->name;
        $data->delete();
        return redirect()->back()->with(['success' => 'Đã xoá thương hiệu '.$name]);
    }

    public function exportPDF()
    {
        // return "sdsd";
        $brans = Brand::with('suppliers')->get();
        $rows = [];
        foreach ($brans as $key => $value) {
            $suppliers = null;
            foreach ($value->suppliers as $supplier) {
                $suppliers = $suppliers."<a href='".route('supplier.show', $supplier->id)."'>- ".$supplier->name."</a><br>";
            }
            $rows[] = [
                $key+1,
                $value->name,
                $suppliers,
                '<a href="'.route('brand.show', $value->id).'">Xem</a>'
            ];
        }

        $data=[
            'title'             =>  'DANH SÁCH THƯƠNG HIỆU',
            'count_record'      =>  'Tổng số thương hiệu: '.count($rows),
            'columns'            =>  ['#', 'Tên thương hiệu', 'Nhà cung cấp', 'Chi tiết'],
            'rows'  => $rows

        ];

        $pdf = PDF::loadView('components.layouts.exportPDF_list', compact('data'));
        return $pdf->download('brands'.date('YmdHms').'.pdf');


    }
}
