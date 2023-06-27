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
        @if (\Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {!! \Session::get('success') !!}
            </div>
        @endif
    </div>
    <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cập nhật thông tin sản phẩm <strong>{{ $data->name }}</strong></h3>
            </div>

            <form id="update" action="{{ route('product.update', $data->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="barcode">Barcode</label>
                                <input type="text" name="barcode" value="{{ $data->barcode }}" class="form-control"
                                    id="barcode" placeholder="Nhập barcode...">
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" name="name" value="{{ $data->name }}" class="form-control"
                                    id="name" placeholder="Nhập tên sản phẩm...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="specification">Quy cách</label>
                                <input type="number" value="{{ $data->specification }}"
                                    name="specification" class="form-control" id="specification" placeholder="Nhập quy cách...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="unit">Đơn vị tính</label>
                                <input type="text" value="{{ $data->unit }}"
                                    name="unit" class="form-control" id="unit" placeholder="Nhập đơn vị tính...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="brand_id">Chọn thương hiệu</label>
                                <select class="form-control select2" name="brand_id"
                                    data-placeholder="Chọn thương hiệu" id="brand_id" style="width: 100%;" >
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $brand->id == $data->brand_id?"selected":"" }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

</x-layouts.main>
