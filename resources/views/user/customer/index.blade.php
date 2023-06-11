<x-layouts.main>
    <div class="col-md-12">
        @if (\Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{-- <h5><i class="icon fas fa-check"></i>Xoá thành công!</h5> --}}
                {!! \Session::get('success') !!}
            </div>
        @endif
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a href="{{ route('customer.create') }}">
                        <button class=" btn btn-sm btn-primary" title="Thêm mới"><i class="fas fa-plus"></i></button>
                    </a>
                    <button class=" btn btn-sm btn-success" title="Xuất file"><i class="fas fa-download"></i></button>
                </h3>

                <div class="card-tools">
                    {{ $customers->links('vendor.pagination.default') }}
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
                            <th>MST</th>
                            <th>Địa chỉ</th>
                            <th>Liên hệ</th>
                            <th style="width: 100px">Thuế suất</th>
                            <th style="width: 90px">Công nợ</th>
                            <th style="width: 100px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->code }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->tax_code }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>{{ $customer->contact['email'] }} <br> {{ $customer->contact['phone'] }}</td>
                                <td>{{ $customer->tax }}</td>
                                <td><button class="btn btn-xs btn-info">Xem</button></td>
                                <td>
                                    <form method="POST" action="{{ route('customer.destroy', $customer->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <a href="{{ route('customer.edit', $customer->id) }}"
                                            class="btn btn-xs btn-warning">Sửa</a>
                                        <span class="btn btn-xs btn-danger delete"
                                            data-id="{{ $customer->name }}">Xoá</span>
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
                if (confirm('Bạn có chắc chắn muốn xoá khách hàng '+name+'?')) {
                    $(e.target).closest('form').submit()
                }
            });
        });
    </script>
</x-layouts.main>
