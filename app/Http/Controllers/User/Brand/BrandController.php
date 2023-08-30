<?php

namespace App\Http\Controllers\User\Brand;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Brand\StoreBrandRequest;
use App\Http\Requests\User\Brand\UpdateBrandRequest;
use App\Models\User\Brand;
use App\Models\User\BrandHistory;
use App\Models\User\Supplier;
use Illuminate\Http\Request;
use PDF;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:brand-view')->only('index');
        $this->middleware('permission:brand-create')->only('create', 'store');
        $this->middleware('permission:brand-view')->only('view', 'show');
        $this->middleware('permission:brand-edit')->only('edit', 'update');
        $this->middleware('permission:brand-delete')->only('destroy');
    }
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
            $data->where(function ($subQuery) use ($columns, $search) {
                foreach ($columns as $column) {
                    $subQuery = $subQuery->orWhere($column, 'LIKE', "%{$search}%");
                }
                return $subQuery;
            });
        }
        $data = $data->paginate(5);
        return view('user.brand.index', compact('data'));
    }

    public function getBrandHis($id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            $data = Brand::with('suppliers')->find($id);
            $history = BrandHistory::with('user_updated', 'user_created')->where(array('brand_id' => $id));
            if ($history->count() == 0) {
                return view('user.brand.show', compact('data'));
            }
            $history = $history->paginate(5);
            return view('user.brand.listHistory', compact('data', 'history'));
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
        $suppliers = Supplier::get();
        return view('user.brand.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandRequest $request)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $supplier_ids = $request->supplier_id;
            $brand = Brand::create([
                'name' => $request->name
            ]);
            $brand->suppliers()->attach($supplier_ids);
            //Update history:
            $his = new BrandHistory();
            $his->brand_id = $brand->id;
            $his->name = $brand->name;
            if ($supplier_ids) {
                $nameSupplier = [];
                $supplierData = Supplier::select('name')->whereIn('id', $supplier_ids)->get()->toArray();
                foreach ($supplierData as $detail) {
                    array_push($nameSupplier, $detail['name']);
                }
                $his->branch_supplier = implode(",", $nameSupplier);
            }
            $his->created_by = \Auth::user()->id;
            $his->save();
            \DB::commit();
            return redirect()->route('brand.index')->with(['success' => 'Thương hiệu ' . $request->name . ' đã được thêm mới!!!']);
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with(['error' => $message])->withInput();
        }
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
    public function update(UpdateBrandRequest $request, $id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $supplier_ids = $request->supplier_id;
            $data = Brand::find($id);
            $data->update($request->all());
            $data->suppliers()->sync($supplier_ids);
            $name = $data->name;
            //Update history:
            $his = new BrandHistory();
            $his->brand_id = $data->id;
            $his->name = $data->name;
            if ($supplier_ids) {
                $nameSupplier = [];
                $supplierData = Supplier::select('name')->whereIn('id', $supplier_ids)->get()->toArray();
                foreach ($supplierData as $detail) {
                    array_push($nameSupplier, $detail['name']);
                }
                $his->branch_supplier = implode(",", $nameSupplier);
            }
            $his->updated_by = \Auth::user()->id;
            $his->save();
            \DB::commit();
            return redirect()->route('brand.show', $id)->with(['success' => 'Thông tin thương hiệu ' . $name . ' đã được cập nhật!!!']);
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with(['error' => $message])->withInput();
        }
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
        return redirect()->back()->with(['success' => 'Đã xoá thương hiệu ' . $name]);
    }

    public function exportPDF()
    {
        // return "sdsd";
        $brans = Brand::with('suppliers')->get();
        $rows = [];
        foreach ($brans as $key => $value) {
            $suppliers = null;
            foreach ($value->suppliers as $supplier) {
                $suppliers = $suppliers . "<a href='" . route('supplier.show', $supplier->id) . "'>- " . $supplier->name . "</a><br>";
            }
            $rows[] = [
                $key + 1,
                $value->name,
                $suppliers,
                '<a href="' . route('brand.show', $value->id) . '">Xem</a>'
            ];
        }

        $data = [
            'title' => 'DANH SÁCH THƯƠNG HIỆU',
            'count_record' => 'Tổng số thương hiệu: ' . count($rows),
            'columns' => ['#', 'Tên thương hiệu', 'Nhà cung cấp', 'Chi tiết'],
            'rows' => $rows

        ];

        $pdf = PDF::loadView('components.layouts.exportPDF_list', compact('data'));
        return $pdf->download('brands' . date('YmdHms') . '.pdf');


    }
}