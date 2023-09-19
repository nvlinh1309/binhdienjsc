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
                    <a href="{{ route('order-buyer.create') }}">
                        <button class=" btn btn-sm btn-primary" title="Tạo đơn hàng">Tạo đơn hàng</button>
                    </a>
                    {{-- <a href="{{ route('order-buyer.cancel') }}">
                        <button class=" btn btn-sm btn-secondary">Đơn hàng đã huỷ</button>
                    </a> --}}



                    {{-- <a href="{{ route('stock-in.list.export') }}">
                    <button class=" btn btn-sm btn-success" title="Xuất file"><i class="fas fa-download"></i></button>
                    </a> --}}
                </h3>

                {{-- <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                        </li>
                    </ul>
                </div> --}}

                <div class="card-tools">
                    {{ $data->links('vendor.pagination.default') }}
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Mã Nhập kho</th>
                            <th>Nhà cung cấp</th>
                            <th>Kho hàng</th>
                            <th>Ngày đặt hàng</th>
                            <th>Trạng thái</th>
                            <th style="width: 100px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $num = 1; ?>
                        @foreach ($data as $key => $value)
                            @php
                                $order_info = json_decode($value->order_info);
                            @endphp
                            <tr>
                                <td>{{ ($data->currentpage() - 1) * $data->perpage() + $key + 1 }}</td>
                                <td>{{ $value->code }}</td>
                                <td>{{ $value->supplier->name }}</td>
                                <td>{{ $value->storage->name }}</td>
                                <td>{{ $order_info->receipt_date }}</td>
                                <td><i class="badge {{ $statusColor[$value->status] }}">{{ $value->status ? $statusList[$value->status] : '' }}</i></td>
                                <td>
                                    <a href="{{ route('order-buyer.show', $value->id) }}"
                                        class="btn btn-xs btn-success">Chi tiết</a>
                                </td>
                            </tr>
                            <?php $num++; ?>
                        @endforeach

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
                if (confirm('Bạn có chắc chắn muốn xoá đơn hàng ' + order_code + '?')) {
                    $(e.target).closest('form').submit()
                }
            });
        });
    </script>
</x-layouts.main>
