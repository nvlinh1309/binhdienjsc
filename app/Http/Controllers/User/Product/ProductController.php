<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\Product\StoreProductRequest;
use App\Models\User\Product;
use App\Models\User\Brand;
use PDF;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Product::orderBy('id', 'DESC');
        if (isset($request->search)) {
            $search = $request->search;
            $columns = ['name', 'barcode', 'brand_name', 'specification'];
            $data->where(function ($subQuery) use ($columns, $search){
                foreach ($columns as $column) {
                  $subQuery = $subQuery->orWhere($column, 'LIKE', "%{$search}%");
                }
                return $subQuery;
              });
        }
        $data = $data->paginate(5);
        return view('user.product.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::get();
        return view('user.product.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Product::create($request->all());
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Product::find($id);
        return view('user.product.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brands = Brand::get();
        $data = Product::find($id);
        return view('user.product.edit', compact('data', 'brands'));
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
        $data = Product::find($id);
        $data->update($request->all());
        $name = $data->name;
        return redirect()->back()->with(['success' => 'Thông tin sản phẩm '.$name.' đã được cập nhật!!!']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::find($id);
        $name = $data->name;
        $data->delete();
        return redirect()->back()->with(['success' => 'Đã xoá sản phẩm '.$name]);
    }

    public function exportPDF()
    {
        // return "sdsd";
        $products = Product::with('brand')->get();
        $rows = [];
        ['name', 'barcode', 'brand_name', 'specification'];
        foreach ($products as $key => $value) {
            $rows[] = [
                $key+1,
                $value->barcode,
                $value->name,
                $value->brand->name,
                $value->specification,
                number_format($value->price),
                $value->unit,
                '<a href="'.route('product.show', $value->id).'">Xem</a>'
            ];
        }

        $data=[
            'title'             =>  'DANH SÁCH SẢN PHẨM',
            'count_record'      =>  'Tổng số sản phẩm: '.count($rows),
            'columns'            =>  ['#', 'Barcode', 'Tên sản phẩm', 'Thương hiệu', 'Quy cách đóng gói', 'Giá sản phẩm', 'ĐVT', 'Chi tiết'],
            'rows'  => $rows

        ];

        $pdf = PDF::loadView('components.layouts.exportPDF_list', compact('data'));
        return $pdf->download('products'.date('YmdHms').'.pdf');


    }
}
