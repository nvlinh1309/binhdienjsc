<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Bao bì</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Sản phẩm</a></li> --}}
                            <li class="breadcrumb-item active">Danh sách</li>
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
                        <a href="{{ route('packaging.create') }}">
                            <button class=" btn btn-sm btn-primary" title="Thêm mới"><i class="fas fa-plus"></i></button>
                        </a>

                        <a href="{{ route('warehouse-receipt.index') }}">
                            <button class=" btn btn-sm btn-success" title="Nhập kho">Nhập kho bao bì</button>
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
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Số lượng</th>
                            <th>Tồn kho</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ ($data->currentpage() - 1) * $data->perpage() + $key + 1 }}</td>
                            <td>BB{{ sprintf("%03d",$value->id) }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->getDetail->sum('quantity') }}</td>
                            <td>{{ $value->getDetail->sum('in_stock') }}</td>
                            <td>{{ $value->created_at }}</td>
                            <td>
                                <a href="{{ route('packaging.show', $value->id) }}">Chi tiết</a>
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
