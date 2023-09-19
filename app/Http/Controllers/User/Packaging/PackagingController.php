<?php

namespace App\Http\Controllers\User\Packaging;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Packaging\CreatePackagingInputRequest;
use Illuminate\Http\Request;
use App\Models\User\Packaging;
use App\Models\User\PackagingStorage;
use App\Http\Requests\User\Packaging\CreatePackagingRequest;
use Facade\Ignition\Support\Packagist\Package;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\User\Packaging\UpdatePackagingRequest;
use App\Models\User\Storage;
use PDF;

class PackagingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Packaging::Where('name', 'LIKE', "%{$request->search}%")->orderBy('id','DESC')->paginate(5);
        return view('user.packaging.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.packaging.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePackagingRequest $request)
    {
        DB::beginTransaction();
        try {
            $packaging=Packaging::create($request->all());
            DB::commit();
            return redirect()->route('packaging.index')->with(['success' => $packaging->name . ' đã được thêm thành công!!!']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
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
        $data = Packaging::find($id);
        if ($data) {
            return view('user.packaging.show', compact('data'));
        }
        return redirect()->route('packaging.index')->with(['error' => "Bao bì không tồn tại"])->withInput();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Packaging::find($id);
        if ($data) {
            return view('user.packaging.edit', compact('data'));
        }
        return redirect()->route('packaging.index')->with(['error' => "Bao bì không tồn tại"])->withInput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackagingRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            $packaging=Packaging::find($id);
            if (!$packaging) {
                return redirect()->route('packaging.index')->with(['error' => 'Cập nhật thất bại!']);
            }
            $packaging -> update($request->all());
            DB::commit();
            return redirect()->route('packaging.show', $id)->with(['success' => $packaging->name . ' đã được cập nhật!!!']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function getInput($id)
    {
        $data = Packaging::find($id);
        $wareHouses = Storage::get();
        if ($data) {
            return view('user.packaging.input', compact('data', 'wareHouses'));
        }
        return redirect()->route('packaging.index')->with(['error' => "Bao bì không tồn tại"])->withInput();
    }

    public function postInput(CreatePackagingInputRequest $request,$id)
    {


        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['in_stock'] = $request->quantity;
            $data['lot'] = "IN".date('ymdHis');
            PackagingStorage::create($data);
            DB::commit();
            return redirect()->route('packaging.show', $id)->with(['success' => 'Nhập kho thành công']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }


    public function exportPDF($lot)
    {


        try {
            $data = PackagingStorage::where($lot)->get();
            if (count($data) == 0) {
                return redirect()->route('packaging.index');
            }
dd($data[0]);
            // return view('user.packaging.export-warehouse-receipt', compact('data'));
            $pdf = PDF::loadView('user.packaging.export-warehouse-receipt', compact('data', 'lot'));
            return $pdf->download('export-warehouse-receipt' . date('YmdHms') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }


    public function wareHouseReceipt(Request $request) //Danh sach phieu nhap kho
    {
        return "dfds";
    }
}
