<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Khách hàng</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <li class="breadcrumb-item"><a href="{{ route('brand.index') }}">Thương hiệu</a></li> --}}
                            <li class="breadcrumb-item active">Khách hàng</li>
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
                    <a href="{{ route('customer.create') }}">
                        <button class=" btn btn-sm btn-primary" title="Thêm mới"><i class="fas fa-plus"></i></button>
                    </a>
                    <a href="{{ route('customer.export') }}">
                        <button class=" btn btn-sm btn-success" title="Xuất file"><i
                                class="fas fa-download"></i></button>
                    </a>
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
                        @foreach ($customers as $key => $customer)
                            <tr>
                                <td>{{ ($customers->currentpage() - 1) * $customers->perpage() + $key + 1 }}</td>
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
                if (confirm('Bạn có chắc chắn muốn xoá khách hàng ' + name + '?')) {
                    $(e.target).closest('form').submit()
                }
            });
        });
    </script>
</x-layouts.main>
