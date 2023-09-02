<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Product\UpdateProductRequest;
use App\Models\User\Customer;
use App\Models\User\PriceCustomerProdManagement;
use App\Models\User\ProductHistory;
use Illuminate\Http\Request;
use App\Http\Requests\User\Product\StoreProductRequest;
use App\Models\User\Product;
use App\Models\User\Brand;
use PDF;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:product-view')->only('index');
        $this->middleware('permission:product-create')->only('create', 'store');
        $this->middleware('permission:product-view')->only('view', 'show');
        $this->middleware('permission:product-edit')->only('edit', 'update');
        $this->middleware('permission:product-delete')->only('destroy');
    }
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
            $data->where(function ($subQuery) use ($columns, $search) {
                foreach ($columns as $column) {
                    $subQuery = $subQuery->orWhere($column, 'LIKE', "%{$search}%");
                }
                return $subQuery;
            });
        }
        $data = $data->paginate(5);
        return view('user.product.index', compact('data'));
    }

    public function getProductHis($id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            $data = Product::find($id);
            $history = ProductHistory::with('user_updated', 'user_created')->where(array('product_id' => $id));
            if ($history->count() == 0) {
                return view('user.product.show', compact('data'));
            }
            $history = $history->paginate(5);
            return view('user.product.listHistory', compact('data', 'history'));
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
        $brands = Brand::get();
        return view('user.product.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $product = Product::create($request->all());
            // Set price for customer
            if ($product) {
                $productId = $product->id;
                $customers = Customer::get();
                foreach ($customers as $customer) {
                    $pri = new PriceCustomerProdManagement();
                    $pri->product_id = $productId;
                    $pri->customer_id = $customer->id;
                    $pri->price = $product->price;
                    $pri->save();
                }
            }
            //Update history
            $his = new ProductHistory();
            $his->product_id = $productId;
            $his->name = $product->name;
            $his->specification = $product->specification;
            $his->barcode = $product->barcode;
            if ($product->brand_id) {
                $brandInfo = Brand::find($product->brand_id);
                $his->brand_name = $brandInfo->name;
            }
            $his->unit = $product->unit;
            $his->price = $product->price;
            $his->created_by = \Auth::user()->id;
            $his->save();
            \DB::commit();
            return redirect()->route('product.index')->with(['success' => 'Sản phẩm đã được tạo thành công.']);
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with(['error' => $message]);
        }
    }

    public function setPriceStore(Request $request)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        try {
            $param = $request->except('_token');
            $productId = $param['product_id'];
            $product = Product::find($productId);
            $param = $request->except('_token', 'product_id');
            if ($product == null) {
                $message = 'Sản phẩm không tồn tại.';
                throw new \Exception($message);
            }
            foreach ($param as $key => $value) {
                $temp = explode('_', $key);
                $customerId = $temp[1];
                $price = PriceCustomerProdManagement::firstOrNew(array('product_id' => $productId, 'customer_id' => $customerId));
                $price->product_id = $productId;
                $price->customer_id = $customerId;
                $price->price = str_replace(',', '', $value);
                $price->save();
            }
            return redirect()->back()->with(['success' => 'Giá của sản phẩm đối với khách hàng đã được cập nhật!!!']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $message]);
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
        $data = Product::with('price_customer', 'price_customer.customer')->find($id);
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
    public function update(UpdateProductRequest $request, $id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        $data = Product::find($id);
        try {
            $data->update($request->all());
            $name = $data->name;

            //Update history
            $his = new ProductHistory();
            $his->product_id = $data->id;
            $his->name = $data->name;
            $his->specification = $data->specification;
            $his->barcode = $data->barcode;
            if ($data->brand_id) {
                $brandInfo = Brand::find($data->brand_id);
                $his->brand_name = $brandInfo->name;
            }
            $his->unit = $data->unit;
            $his->price = $data->price;
            $his->updated_by = \Auth::user()->id;
            $his->save();
            \DB::commit();
            return redirect()->back()->with(['success' => 'Thông tin sản phẩm ' . $name . ' đã được cập nhật!!!']);
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
        $data = Product::find($id);
        $name = $data->name;
        $data->delete();
        return redirect()->back()->with(['success' => 'Đã xoá sản phẩm ' . $name]);
    }

    public function exportPDF()
    {
        // return "sdsd";
        $products = Product::with('brand')->get();
        $rows = [];
        ['name', 'barcode', 'brand_name', 'specification'];
        foreach ($products as $key => $value) {
            $rows[] = [
                $key + 1,
                $value->barcode,
                $value->name,
                $value->brand->name,
                $value->specification,
                number_format($value->price),
                $value->unit,
                '<a href="' . route('product.show', $value->id) . '">Xem</a>'
            ];
        }

        $data = [
            'title' => 'DANH SÁCH SẢN PHẨM',
            'count_record' => 'Tổng số sản phẩm: ' . count($rows),
            'columns' => ['#', 'Barcode', 'Tên sản phẩm', 'Thương hiệu', 'Quy cách đóng gói', 'Giá sản phẩm', 'ĐVT', 'Chi tiết'],
            'rows' => $rows

        ];

        $pdf = PDF::loadView('components.layouts.exportPDF_list', compact('data'));
        return $pdf->download('products' . date('YmdHms') . '.pdf');


    }
}