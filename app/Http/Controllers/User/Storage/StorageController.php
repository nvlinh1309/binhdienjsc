<?php

namespace App\Http\Controllers\User\Storage;

use App\Http\Controllers\Controller;
use App\Models\User\Storage;
use Illuminate\Http\Request;
use PDF;

class StorageController extends Controller
{
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
            $columns = ['name', 'address','code'];
            $data->where(function ($subQuery) use ($columns, $search){
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
    public function store(Request $request)
    {
        Storage::create($request->all());
        return redirect()->route('store.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Storage::find($id);
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
        $data = Storage::find($id);
        $name = $data->name;
        $data->delete();
        return redirect()->back()->with(['success' => 'Đã xoá thành công kho '.$name]);
    }

    public function exportPDF()
    {
        // return "sdsd";
        $storages = Storage::get();
        $rows = [];
        foreach ($storages as $key => $value) {
            $rows[] = [
                $key+1,
                $value->code,
                $value->name,
                $value->address
            ];
        }

        $data=[
            'title'             =>  'DANH SÁCH KHO',
            'count_record'      =>  'Tổng số kho: '.count($rows),
            'columns'            =>  ['#', 'Mã kho', 'Tên kho', 'Địa chỉ'],
            'rows'  => $rows

        ];

        $pdf = PDF::loadView('components.layouts.exportPDF', compact('data'));
        return $pdf->download('store'.date('YmdHms').'.pdf');


    }
}
