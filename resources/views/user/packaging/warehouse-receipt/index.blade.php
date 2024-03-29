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
                            <li class="breadcrumb-item"><a href="{{ route('packaging.index') }}">Danh sách bao bì</a></li>
                            <li class="breadcrumb-item active">Danh sách phiếu nhập kho</li>
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
                    @can('product-create')
                        <a href="{{ route('warehouse-receipt.create') }}">
                            <button class=" btn btn-sm btn-primary" title="Thêm mới"><i class="fas fa-plus"></i></button>
                        </a>
                    @endcan
                    {{-- <a href="{{ route('packaging.index') }}">
                        <button class=" btn btn-sm btn-success" title="Xuất file"><i
                                class="fas fa-download"></i></button>
                    </a> --}}
                </h3>

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
                            <th>Mã nhập kho</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ ($data->currentpage() - 1) * $data->perpage() + $key + 1 }}</td>
                            <td>{{ $value->lot }}</td>
                            <td>{{ $value->created_at }}</td>
                            <td>
                                @if ($value->status == true)
                                    <span class="badge badge-success">Đã nhập kho</span>
                                @else
                                    <span class="badge badge-danger">Chờ nhập kho</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('warehouse-receipt.show', $value->lot) }}">Xem</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <script>
        // $(document).ready(function() {
        //     $('.delete').on('click', function(e) {
        //         var name = $(this).attr('data-id');
        //         e.preventDefault()
        //         if (confirm('Bạn có chắc chắn muốn xoá sản phẩm ' + name + '?')) {
        //             $(e.target).closest('form').submit()
        //         }
        //     });
        // });
    </script>
</x-layouts.main>
