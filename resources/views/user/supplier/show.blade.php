<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Nhà cung cấp</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Danh sách</a></li>
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
    <div class="col-md-12">
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Thông tin</h5>
            <div><b>Mã:</b> {{ $data->supplier_code }}</div>
            <div><b>Tên công ty:</b> {{ $data->name }}</div>
            <div><b>Địa chỉ:</b> {{ $data->address }}</div>
            <div><b>Mã số thuế:</b> {{ $data->tax_code }}</div>
            <div><b>Ngày tạo:</b> {{ $data->created_at }}</div>
            <div><b>Ngày cập nhật cuối cùng:</b> {{ $data->updated_at ?? $data->created_at }}</div>
            <br>
            {{-- <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Quay lại</button> --}}
            <button class="btn btn-warning" onclick="window.location='{{ route('supplier.edit', $data->id) }}'">Chỉnh
                sửa</button>
        </div>

    </div>

</x-layouts.main>
