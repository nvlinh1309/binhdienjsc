<?php

namespace App\Http\Controllers\User\Storage;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Storage\StoreStorageRequest;
use App\Http\Requests\User\Storage\UpdateStorageRequest;
use App\Models\User\Storage;
use App\Models\User\StorageHistory;
use Illuminate\Http\Request;
use PDF;

class StorageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:warehouse-view')->only('index');
        $this->middleware('permission:warehouse-create')->only('create', 'store');
        $this->middleware('permission:warehouse-view')->only('view', 'show');
        $this->middleware('permission:warehouse-edit')->only('edit', 'update');
        $this->middleware('permission:warehouse-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Storage::orderBy('id', 'DESC');
        if (isset($request->search)) {
            $search = $request->search;
            $columns = ['name', 'address', 'code'];
            $data->where(function ($subQuery) use ($columns, $search) {
                foreach ($columns as $column) {
                    $subQuery = $subQuery->orWhere($column, 'LIKE', "%{$search}%");
                }
                return $subQuery;
            });
        }
        $data = $data->paginate(5);
        return view('user.storage.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.storage.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStorageRequest $request)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $storage = Storage::create($request->all());
            // --------------------------
            $his = new StorageHistory();
            $his->storage_id = $storage->id;
            $his->name = $storage->name;
            $his->address = $storage->address;
            $his->code = $storage->code;
            $his->created_by = \Auth::user()->id;
            // $his->updated_by = \Auth::user()->id;
            $his->save();
            \DB::commit();
            return redirect()->route('store.index')->with(['success' => 'Kho hàng ' . $storage->name . ' đã được tạo thành công!!!']);
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
        $data = Storage::with('storage_product', 'storage_product.product')->find($id);
        if (!$data) {
            abort(404);
        }
        return view('user.storage.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Storage::find($id);
        return view('user.storage.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStorageRequest $request, $id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $data = Storage::find($id);
            $data->update($request->all());
            $name = $data->name;
            //
            $his = new StorageHistory();
            $his->storage_id = $data->id;
            $his->name = $data->name;
            $his->address = $data->address;
            $his->code = $data->code;
            // $his->created_by = \Auth::user()->id;
            $his->updated_by = \Auth::user()->id;
            $his->save();
            \DB::commit();
            return redirect()->route('store.show', $id)->with(['success' => 'Thông tin kho ' . $name . ' đã được cập nhật!!!']);
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with(['error' => $message])->withInput();
        }
    }

    public function getStorageHis($id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            $data = Storage::with('storage_product', 'storage_product.product')->find($id);
            $history = StorageHistory::with('user_updated', 'user_created')->where(array('storage_id' => $id));
            if($history->count() == 0) {
                return view('user.storage.show', compact('data'));
            }
            $history = $history->paginate(5);
            return view('user.storage.listHistory', compact('data', 'history'));
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
        $data = Storage::find($id);
        $name = $data->name;
        $data->delete();
        return redirect()->back()->with(['success' => 'Đã xoá thành công kho ' . $name]);
    }

    public function warehouseReceipt()
    {
        // Nhap kho

    }

    public function warehouseExport()
    {
        // Xuat kho

    }

    public function exportPDF()
    {
        // return "sdsd";
        $storages = Storage::with('storage_product')->get();
        $rows = [];
        foreach ($storages as $key => $value) {
            $rows[] = [
                $key + 1,
                $value->code,
                $value->name,
                $value->address,
                $value->storage_product->count(),
                '<a href="' . route('store.show', $value->id) . '">Xem</a>'
            ];
        }

        $data = [
            'title' => 'DANH SÁCH KHO',
            'count_record' => 'Tổng số kho: ' . count($rows),
            'columns' => ['#', 'Mã kho', 'Tên kho', 'Địa chỉ', 'Tổng sản phẩm', 'Chi tiết'],
            'rows' => $rows

        ];

        $pdf = PDF::loadView('components.layouts.exportPDF_list', compact('data'));
        return $pdf->download('store' . date('YmdHms') . '.pdf');


    }
}