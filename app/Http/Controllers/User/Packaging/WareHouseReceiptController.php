<?php

namespace App\Http\Controllers\User\Packaging;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\PackagingStorage;
use PDF;
use App\Models\User\Packaging;
use App\Models\User\Storage;

class WareHouseReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = PackagingStorage::orderBy('id','DESC')-> distinct('lot')->paginate(5);
        return view('user.packaging.warehouse-receipt.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packaging = Packaging::get();
        $wareHouses = Storage::get();
        return view('user.packaging.warehouse-receipt.create', compact('packaging', 'wareHouses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $lot = "IN".date('ymdHis');
            $data = json_decode($request->packaging);
            $storage_id = $request->storage_id;
            foreach ($data as $key => $value) {
                PackagingStorage::create([
                    'storage_id'    =>  $storage_id,
                    'packaging_id'  =>  $value->packaging_id,
                    'quantity'      =>  $value->quantity!=""?$value->quantity:0,
                    'lot'           =>  $lot,
                    'in_stock'      =>  $value->quantity!=""?$value->quantity:0,
                    'note'          =>  $value->note,
                    'contract_quantity' => $value->contract_quantity!=""?$value->contract_quantity:0
                ]);
            }
            return redirect()->route('warehouse-receipt.show', $lot)->with(['success' => 'Tạo thành công!!!']);;
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lot)
    {
        $data = PackagingStorage::where('lot',$lot)->get();
        if (count($data) > 0) {
            $info = $data[0];
            return view('user.packaging.warehouse-receipt.show', compact('data', 'info'));
        }

        return redirect()->route('warehouse-receipt.index')->with(['error' => "Mã phiếu nhập kho không tồn tại"])->withInput();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return "Tính năng đang trong giai đoạn phát triển";
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

    public function exportPDF($lot)
    {


        try {
            $data = PackagingStorage::where('lot',$lot)->get();
            if (count($data) == 0) {
                return redirect()->route('packaging.index');
            }
            $info = $data[0];
            // return view('user.packaging.warehouse-receipt.export-warehouse-receipt', compact('data', 'info'));
            $pdf = PDF::loadView('user.packaging.warehouse-receipt.export-warehouse-receipt', compact('data', 'info'));
            PackagingStorage::where('lot',$lot)->update([
                'status'=> true
                ]);
            return $pdf->download('export-warehouse-receipt' . date('YmdHms') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }
}
