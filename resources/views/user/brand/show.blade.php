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
                            <li class="breadcrumb-item"><a href="{{ route('brand.index') }}">Thương hiệu</a></li>
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
            <div><b>Tên thương hiệu:</b> {{ $data->name }}</div>
            <div><b>Ngày tạo:</b> {{ $data->created_at }}</div>
            <div><b>Nhà cung cấp:</b> </div>
            {{-- <hr> --}}
            @foreach ($data->suppliers as $value)
                <li>{{ $value->name }}</li>
            @endforeach

            <hr>

            {{-- <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Quay lại</button> --}}
            <button class="btn btn-warning" onclick="window.location='{{ route("brand.edit",$data->id) }}'">Chỉnh sửa</button>
        </div>

    </div>

</x-layouts.main>
