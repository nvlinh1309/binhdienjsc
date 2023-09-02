<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Thương hiệu</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <li class="breadcrumb-item"><a href="{{ route('brand.index') }}">Thương hiệu</a></li> --}}
                            <li class="breadcrumb-item active">Thương hiệu</li>
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
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    @can('brand-create')
                        <a href="{{ route('brand.create') }}">
                            <button class=" btn btn-sm btn-primary" title="Thêm mới"><i class="fas fa-plus"></i></button>
                        </a>
                    @endcan
                    <a href="{{ route('brand.export') }}">
                        <button class=" btn btn-sm btn-success" title="Xuất file"><i
                                class="fas fa-download"></i></button>
                    </a>
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
                            <th>Tên thương hiệu</th>
                            <th>Nhà cung cấp</th>
                            <th style="width: 100px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $value)
                            <tr>
                                <td>{{ ($data->currentpage() - 1) * $data->perpage() + $key + 1 }}</td>
                                <td>{{ $value->name }}</td>
                                <td>
                                    @foreach ($value->suppliers as $supplier)
                                        <div>- {{ $supplier->name }}</div>
                                    @endforeach

                                </td>
                                <td>
                                    <form method="POST" action="{{ route('brand.destroy', $value->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        @can('brand-view')
                                            <a href="{{ route('brand.show', $value->id) }}"
                                                class="btn btn-xs btn-warning">Xem</a>
                                        @endcan
                                        @can('brand-delete')
                                            {{-- <span class="btn btn-xs btn-danger delete"
                                                data-id="{{ $value->name }}">Xoá</span> --}}
                                        @endcan
                                    </form>
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
        $(document).ready(function() {
            $('.delete').on('click', function(e) {
                var name = $(this).attr('data-id');
                e.preventDefault()
                if (confirm('Bạn có chắc chắn muốn xoá khách hàng ' + name + '?')) {
                    $(e.target).closest('form').submit()
                }
            });
        });
    </script>
</x-layouts.main>
