<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Đơn mua</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('order-buyer.index') }}">Danh sách</a></li>
                            <li class="breadcrumb-item active">Đơn mua</li>
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
        {{-- <div class="card"> --}}

        <div class="callout callout-info">
            <div class="card-header pl-0">
                {{-- <h3 class="card-title"> --}}
                    <a style="text-decoration: none;" href="{{ route('order-buyer.purchase-order-export', $data->id) }}">
                        <button class=" btn btn-sm btn-primary" >Xuất đơn đặt hàng</button>
                    </a>
                    {{-- <a style="text-decoration: none;" href="{{ route('instock.invoice', $data->id) }}">
                        <button class=" btn btn-sm btn-info" title="Tạo đơn hàng">Xuất đơn đặt hàng</button>
                    </a> --}}
                {{-- </h3> --}}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5><i class="fas fa-info"></i> Thông tin</h5>
                </div>
                <div class="col-md-6">
                    <b>Mã đơn hàng:</b> {{ $data->code }}
                </div>
                <div class="col-md-6">
                    <b>Assignee:</b> {{ $data->user_assignee->name }}
                </div>
                <div class="col-md-6">
                    <b>Nhà cung cấp:</b> <a href="{{ route('supplier.show', $data->supplier->id) }}">{{ $data->supplier->name }}</a>
                </div>
                <div class="col-md-6">
                    <b>Kho:</b> <a href="{{ route('store.show', $data->storage->id) }}">{{ $data->storage->name }}</a>
                </div>
                <div class="col-md-6">
                    <b>Ngày tạo đơn:</b> {{ $order_info->receipt_date }}
                </div>
            </div>

            {{-- <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Quay lại</button> --}}
            {{-- <button @if ($data->receipt_status === 4) disabled @endif class="btn btn-warning"
                onclick="window.location='{{ route('order-buyer.edit', $data->id) }}'">Chỉnh sửa</button> --}}
        </div>
            <!-- /.card-header -->

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
