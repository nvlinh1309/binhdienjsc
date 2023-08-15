<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Xét giá sản phẩm theo Khách hàng</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <li class="breadcrumb-item"><a href="{{ route('brand.index') }}">Thương hiệu</a></li> --}}
                            {{-- <li class="breadcrumb-item active">Danh sách đơn mua (Nhập kho)</li> --}}
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    @stop()
    <div class="col-md-12">
        @if (\Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {!! \Session::get('success') !!}
            </div>
        @endif
        @if (\Session::has('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {!! \Session::get('error') !!}
            </div>
        @endif
    </div>
    <div class="col-md-12">
        <div class="card">
            
            <div class="callout callout-info">
            <div class="card-header pl-0">
                <h3 class="card-title">
                    <a href="{{ route('instock.export', $goodReceiptManagement->id) }}">
                        <button class=" btn btn-sm btn-primary" title="Tạo đơn hàng">Xuất phiếu nhập kho</button>
                    </a>
                </h3>
            </div>
                <h5><i class="fas fa-info"></i> Thông tin</h5>
                <div><b>Mã nhập kho:</b> {{ $goodReceiptManagement->goods_receipt_code }}</div>
                <div><b>Nhà cung cấp:</b> {{ $goodReceiptManagement->supplier->name }}</div>
                <div><b>Chứng từ (Mã hợp đồng,v.v...):</b> {{ $goodReceiptManagement->document }}</div>
                <div><b>Kho:</b> {{ $goodReceiptManagement->storage->name }}</div>
                <div><b>Ngày nhập kho:</b> {{ $goodReceiptManagement->receipt_date ?$goodReceiptManagement->receipt_date->format('d-m-Y') :'' }}</div>
                <div><b>Ngày tạo:</b> {{ $goodReceiptManagement->created_at->format('d-m-Y') }}</div>
                <div><b>Thông tin giao nhận:</b> {{ $goodReceiptManagement->receive_info }}</div>
                <div><b>Xe/Cont:</b> {{ $goodReceiptManagement->receive_cont }}</div>
                <div><b>Người phê duyệt:</b> {{ $goodReceiptManagement->approval_user ? $goodReceiptManagement->approvalUser->name : '' }}</div>
                <div><b>Bộ phận giao nhận:</b> {{  $goodReceiptManagement->receive_user ? $goodReceiptManagement->receiveUser->name : ''}}</div>
                <div><b>Thủ kho hàng:</b> {{ $goodReceiptManagement->wh_user ? $goodReceiptManagement->whUser->name : ''}}</div>
                <div><b>Phụ trách tổ kinh doanh:</b> {{ $goodReceiptManagement->sales_user ? $goodReceiptManagement->saleUser->name : ''}}</div>
                <div><b>Trạng thái đơn hàng:</b> {{ $goodReceiptManagement->receipt_status ? $statusList[$goodReceiptManagement->receipt_status] : '' }}</div>
                {{-- <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Quay lại</button> --}}
                <button @if($goodReceiptManagement->receipt_status == 3) disabled @endif class="btn btn-warning" onclick="window.location='{{ route("stock-in.edit",$goodReceiptManagement->id) }}'">Chỉnh sửa</button>
            </div>

            {{-- <div class="card-header"> --}}
            {{-- <h3 class="card-title"> --}}
            {{-- Mã nhập kho: {{ $goodReceiptManagement->goods_receipt_code }} --}}
            {{-- <a href="{{ route('stock-in.create') }}">
                        <button class=" btn btn-sm btn-primary" title="Tạo đơn hàng">Tạo đơn hàng</button>
                    </a>
                    <button class=" btn btn-sm btn-success disabled" title="Xuất file"><i class="fas fa-download"></i></button> --}}
            {{-- </h3> --}}

            {{-- <div class="card-tools"> --}}
            {{-- {{ $data->links('vendor.pagination.default') }} --}}
            {{-- </div> --}}
            {{-- </div> --}}
            <!-- /.card-header -->
            {{-- <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh sách khách hàng</th>
                            <th>Giá</th>
                            <th>Lưu</th>
                        </tr>
                    </thead>
                    <tbody>
                            <form id="setPriceForm" action="{{ route('stock-in.price.store') }}" method="POST">
                            @csrf
                                <tr>
                                    <td>{{ $num }}</td>
                                    <td>
                                        <select name="product_name" class="form-control select2" required>
                                            @foreach ($productsGoodReceipt as $productsGood)
                                                <option value="{{ $productsGood->id }}">{{ $productsGood->product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="customer_id" class="form-control select2" required>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="price" class="form-control"
                                            id="" placeholder="Nhập giá đối với khách hàng..." required>
                                    </td>
                                    <td>
                                        <button type="submit"  class="btn btn-secondary">Lưu</button>
                                    </td>
                                </tr>
                            </form>

                    </tbody>
                </table>
            </div> --}}
            <!-- /.card-body -->
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Danh sách sản phẩm kèm giá theo khách hàng
                    {{-- <a href="{{ route('stock-in.create') }}">
                        <button class=" btn btn-sm btn-primary" title="Tạo đơn hàng">Tạo đơn hàng</button>
                    </a>
                    <button class=" btn btn-sm btn-success disabled" title="Xuất file"><i class="fas fa-download"></i></button> --}}
                </h3>

                <div class="card-tools">
                    {{-- {{ $data->links('vendor.pagination.default') }} --}}
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <form id="setPriceForm" action="{{ route('stock-in.price.store') }}" method="POST">
                <input type="hidden" name="good_receipt_id" value="{{$goodReceiptManagement->id}}"/>
                <table class="table">
                    @csrf
                    @foreach ($listProductPrice as $productPrice)
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th >Sản phẩm: {{ $productPrice->product->name }}</th>
                                <th >Giá (VNĐ)</th>
                                <th >Số lượng</th>
                                <th >Ngày sản xuất</th>
                                <th >Hạn sử dụng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($productPrice->prices) > 0)
                                <?php $num = 1; ?>
                                @foreach ($productPrice->prices as $detailPrice)
                                    <tr>
                                        <td>{{ $num }}</td>
                                        <td>
                                            {{ $detailPrice->customer->name }}
                                        </td>
                                        <td>
                                            <input type="text" name="price_{{$productPrice->id}}_{{$detailPrice->customer_id}}" class="form-control"
                                                id="" value="{{ $detailPrice->price }}"
                                                placeholder="Nhập giá đối với khách hàng...">
                                        </td>
                                        <td>
                                            {{ $productPrice->quantity }}
                                        </td>
                                        <td>
                                            {{ $productPrice->date_of_manufacture ? $productPrice->date_of_manufacture->format('d-m-Y') : '' }}
                                        </td>
                                        <td>
                                            {{ $productPrice->expiry_date ? $productPrice->expiry_date->format('d-m-Y') : ''}}
                                        </td>
                                    </tr>
                                    <?php $num++; ?>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">Sản phẩm chưa xét giá cho khách hàng.</td>
                                </tr>
                            @endif
                        </tbody>
                    @endforeach
                </table>
                <div class="callout">
                <button type="submit"  class="btn btn-secondary">Cập nhật giá</button>
                </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.delete').on('click', function(e) {
                var order_code = $(this).attr('data-id');
                e.preventDefault()
                if (confirm('Bạn có chắc chắn muốn xoá đơn hàng ' + namorder_codee + '?')) {
                    $(e.target).closest('form').submit()
                }
            });
        });
    </script>
</x-layouts.main>
