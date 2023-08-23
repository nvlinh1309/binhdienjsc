<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kho</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('store.index') }}">Danh sách kho</a></li>
                            <li class="breadcrumb-item active">{{ $data->name }}</li>
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
    <div class="col-md-12 float-right">
        <p class="mb-2 float-right"><a class="link-opacity-100" href="{{ route('store.history', $data->id) }}">Lịch
                sử</a></p>
    </div>
    <div class="col-md-12">
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Thông tin</h5>
            <div><b>Mã:</b> {{ $data->code }}</div>
            <div><b>Tên kho:</b> {{ $data->name }}</div>
            <div><b>Địa chỉ:</b> {{ $data->address }}</div>
            <div><b>Ngày tạo:</b> {{ $data->created_at }}</div>
            <div><b>Ngày cập nhật cuối cùng:</b> {{ $data->updated_at ?? $data->created_at }}</div>
            <br>
            {{-- <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Quay lại</button> --}}
            <button class="btn btn-warning" onclick="window.location='{{ route('store.edit', $data->id) }}'">Chỉnh
                sửa</button>
        </div>

    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Danh sách sản phẩm trong kho
                </h3>

                <div class="card-tools">

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Barcode</th>
                            <th>Tên Sản phẩm</th>
                            <th>Thương hiệu</th>
                            <th>Tồn kho</th>
                            <th style="width: 120px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->storage_product as $key => $value)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->product->barcode }}</td>
                                <td>{{ $value->product->name }}</td>
                                <td>{{ $value->product->brand->name }}</td>
                                <td>{{ $value->quantity_plus - $value->quantity_mins }}</td>
                                <td>
                                    <a href="http://127.0.0.1:8000/store/1" class="btn btn-xs btn-warning">Chi tiêt</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</x-layouts.main>
