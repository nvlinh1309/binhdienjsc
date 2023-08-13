<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Chi tiết đơn hàng</h1>
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
                    <a href="{{ route('order.export', $order->id) }}">
                        <button class=" btn btn-sm btn-primary" title="Tạo đơn hàng">Xuất phiếu xuất kho</button>
                    </a>
                </h3>
            </div>
                <h5><i class="fas fa-info"></i> Thông tin</h5>
                <div><b>Mã đơn hàng:</b> {{ $order->order_code }}</div>
                <div><b>Tên khách hàng:</b> {{ $order->customer->name }}</div>
                <div><b>Chứng từ (Mã hợp đồng,v.v...):</b> {{ $order->document }}</div>
                <div><b>Kho:</b> {{ $order->storage->name }}</div>
                <div><b>Hình thức thanh toán:</b> {{ $order->payment_method ? $paymentMethodList[$order->payment_method] : '' }}</div>
                <div><b>Thông tin giao nhận:</b> {{ $order->receive_info }}</div>
                <div><b>Xe/Cont:</b> {{ $order->receive_cont }}</div>
                <div><b>Ngày xuất kho:</b> {{ $order->delivery_date ? $order->delivery_date->format('d-m-Y') :'' }}</div>
                <div><b>Bộ phận giao nhận:</b> {{  $order->receive_user ? $order->receiveUser->name : ''}}</div>
                <div><b>Thủ kho hàng:</b> {{ $order->wh_user ? $order->whUser->name : ''}}</div>
                <div><b>Phụ trách tổ kinh doanh:</b> {{ $order->sales_user ? $order->saleUser->name : ''}}</div>
                <div><b>Trạng thái đơn hàng:</b> {{ $order->order_status ? $statusList[$order->order_status] : '' }}</div>
                <div><b>Người phê duyệt:</b> {{ $order->approval_user ? $order->approvalUser->name : '' }}</div>
                <div><b>Ngày tạo:</b> {{ $order->created_at->format('d-m-Y') }}</div>
                {{-- <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Quay lại</button> --}}
                <button @if($order->order_status == 3) disabled @endif class="btn btn-warning" onclick="window.location='{{ route("order.edit",$order->id) }}'">Chỉnh sửa</button>
            </div>

            
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Danh sách sản phẩm của lần xuất kho
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
                <table class="table">
                    @csrf
                    
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th >Tên sản phẩm</th>
                                <th >Giá (VNĐ)</th>
                                <th >Số lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($order->order_detail) > 0)
                                <?php $num = 1; ?>
                                @foreach ($order->order_detail as $productExport)
                                    <tr>
                                        <td>{{ $num }}</td>
                                        <td>{{ $productExport->product->name }}</td>
                                        <td>
                                            {{ $productExport->price ? number_format($productExport->price) : '' }}
                                        </td>
                                        <td>
                                            {{ $productExport->quantity }}
                                        </td>
                                    </tr>
                                    <?php $num++; ?>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">Không tồn tại sản phẩm của đơn hàng.</td>
                                </tr>
                            @endif
                        </tbody>
                </table>
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
