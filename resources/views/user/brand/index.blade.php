<x-layouts.main>
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
                    <a href="{{ route('brand.create') }}">
                        <button class=" btn btn-sm btn-primary" title="Thêm mới"><i class="fas fa-plus"></i></button>
                    </a>
                    <button class=" btn btn-sm btn-success" title="Xuất file"><i class="fas fa-download"></i></button>
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
                        @foreach ($data as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
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
                                        <a href="{{ route('brand.edit', $value->id) }}"
                                            class="btn btn-xs btn-warning">Sửa</a>
                                        <span class="btn btn-xs btn-danger delete"
                                            data-id="{{ $value->name }}">Xoá</span>
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
