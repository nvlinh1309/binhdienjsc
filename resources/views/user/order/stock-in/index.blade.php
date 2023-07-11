<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Đơn mua (Nhập kho)</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <li class="breadcrumb-item"><a href="{{ route('brand.index') }}">Thương hiệu</a></li> --}}
                            <li class="breadcrumb-item active">Danh sách đơn mua (Nhập kho)</li>
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
            <div class="card-header">
                <h3 class="card-title">
                    <a href="{{ route('stock-in.create') }}">
                        <button class=" btn btn-sm btn-primary" title="Tạo đơn hàng">Tạo đơn hàng</button>
                    </a>
                    <button class=" btn btn-sm btn-success disabled" title="Xuất file"><i class="fas fa-download"></i></button>
                </h3>

                <div class="card-tools">
                    {{-- {{ $data->links('vendor.pagination.default') }} --}}
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                {{-- <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Ngày tạo đơn</th>
                            <th>Hình thức thanh toán</th>
                            <th>Trạng thái</th>
                            <th style="width: 100px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $value)
                            <tr>
                                <td>{{ $value->order_code }}</td>
                                <td>{{ $value->customer_id }}</td>
                                <td>{{ $value->created_at }}</td>
                                <td>{{ $value->payment_method }}</td>
                                <td>{{ $value->status }}</td>
                                <td>
                                    <form method="POST" action="{{ route('order.destroy', $value->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <a href="{{ route('order.edit', $value->id) }}"
                                            class="btn btn-xs btn-warning">Sửa</a>
                                        <span class="btn btn-xs btn-danger delete"
                                            data-id="{{ $value->order_code }}">Xoá</span>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table> --}}
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.delete').on('click', function(e) {
                var order_code = $(this).attr('data-id');
                e.preventDefault()
                if (confirm('Bạn có chắc chắn muốn xoá đơn hàng '+namorder_codee+'?')) {
                    $(e.target).closest('form').submit()
                }
            });
        });
    </script>
</x-layouts.main>
