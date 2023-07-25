<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sản phẩm</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Sản phẩm</a></li>
                            <li class="breadcrumb-item active">{{ $data->name }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    @stop()
    <div class="col-md-12">
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Thông tin</h5>
            <div><b>Tên sản phẩm:</b> {{ $data->name }}</div>
            <div><b>Barcode:</b> {{ $data->barcode }}</div>
            <div><b>Thương hiệu:</b> {{ $data->brand->name }}</div>
            <div><b>Quy cách đóng gói:</b> {{ $data->specification }} ({{$data->unit}})</div>
            <div><b>Giá sản phẩm:</b> {{ number_format($data->price) }}</div>
            <div><b>Ngày tạo:</b> {{ $data->created_at }}</div>
            <hr>
            <div><b>Tồn kho:</b> 0</div>
            <div><b>Đã bán:</b> 0</div>
            <hr>

            {{-- <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Quay lại</button> --}}
            <button class="btn btn-warning" onclick="window.location='{{ route("product.edit",$data->id) }}'">Chỉnh sửa</button>
        </div>

    </div>

</x-layouts.main>
