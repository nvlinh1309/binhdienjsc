<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Phiếu nhập kho</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('warehouse-receipt.index') }}">Phiếu nhập kho</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $info->lot }}</li>
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
    <div class="col-md-12 float-right">
        <p class="mb-2 float-right"><a class="link-opacity-100" href="#">Lịch
                sử</a></p>
    </div>
    <div class="col-md-12">
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Thông tin</h5>
            <div><b>Mã nhập:</b> {{ $info->lot }}</div>
            <div><b>Kho:</b> {{ $info->storage->name }}</div>
            <div><b>Trạng thái:</b>
                @if ($info->status == true)
                    <span class="badge badge-success">Đã nhập kho</span>
                @else
                    <span class="badge badge-danger">Chờ nhập kho</span>
                @endif

            </div>
            <hr>

            {{-- <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Quay lại</button> --}}
            {{-- @can('product-edit')
                <button class="btn btn-warning" onclick="window.location='{{ route('packaging.edit', $data->id) }}'">Chỉnh
                    sửa</button>
            @endcan --}}
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Chi tiết
                </h3>

                <div class="card-tools">
                    <form method="POST" action="{{ route('warehouse-receipt.destroy', $info->lot) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        @if ($info->status == false)
                            <a href="{{ route('warehouse-receipt.edit', $info->lot) }}"
                                class="btn btn-sm btn-primary">Cập
                                nhật</a>

                            <a href="#" class="btn btn-sm btn-danger delete" data-id="{{ $info->lot }}">Huỷ</a>
                        @endif
                        <a href="{{ route('warehouse-receipt.export', $info->lot) }}"
                            onclick="return confirm('Việc xác nhận xuất phiếu nhập kho, đồng nghĩa số lượng sẽ được cộng vào kho và không được chỉnh sửa. Bạn có chắc chắn tiếp tục xuất phiếu?')"
                            class="btn btn-sm btn-success">Xuất phiếu
                            @if ($info->status == false)
                                và nhập kho
                            @endif
                        </a>
                    </form>
                </div>
            </div>
            <!-- /.card-header -->

            <div class="card-body p-0">

                <table class="table">
                    <thead>
                        <tr>

                            <th>Tên bao bì</th>
                            <th>Số lượng hợp đồng</th>
                            <th>Số lượng thực nhận</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $value)
                            <tr>
                                <td>{{ $value->packaging->name }}</td>
                                <td>{{ $value->contract_quantity }}</td>
                                <td>{{ $value->quantity }}</td>
                                <td>{{ $value->note }}</td>
                            </tr>
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
                var name = $(this).attr('data-id');
                e.preventDefault()
                if (confirm('Bạn có chắc chắn muốn huỷ ' + name + '?')) {
                    $(e.target).closest('form').submit()
                }
            });
        });
    </script>
</x-layouts.main>
