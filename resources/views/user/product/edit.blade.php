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
                <input type="hidden" value="{{ $data->id }}" name="id" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="barcode">Barcode</label><span class="text-danger">*</span>
                                <input type="text" name="barcode" value="{{ old('barcode', $data->barcode) }}" class="form-control {{ $errors->has('barcode')?"is-invalid":"" }}"
                                    id="barcode" placeholder="Nhập barcode...">
                                    @if ($errors->has('barcode'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('barcode') }}</div>
                                @endif
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label><span class="text-danger">*</span>
                                <input type="text" name="name" value="{{ old('name', $data->name) }}" class="form-control {{ $errors->has('name')?"is-invalid":"" }}"
                                    id="name" placeholder="Nhập tên sản phẩm...">
                                    @if ($errors->has('name'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="specification">Quy cách</label><span class="text-danger">*</span>
                                <input type="number" value="{{ old('specification', $data->specification) }}"
                                    name="specification" class="form-control {{ $errors->has('specification')?"is-invalid":"" }}" id="specification" placeholder="Nhập quy cách...">
                                    @if ($errors->has('specification'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('specification') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="unit">Đơn vị tính</label><span class="text-danger">*</span>
                                <input type="text" value="{{ old('unit', $data->unit) }}"
                                    name="unit" class="form-control {{ $errors->has('unit')?"is-invalid":"" }}" id="unit" placeholder="Nhập đơn vị tính...">
                                    @if ($errors->has('unit'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('unit') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="unit">Giá sản phẩm</label><span class="text-danger">*</span>
                                <input type="text" value="{{ old('price', $data->price) }}"
                                    name="price" class="form-control {{ $errors->has('price')?"is-invalid":"" }}" id="price" placeholder="Nhập giá sản phẩm...">
                                    @if ($errors->has('price'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('price') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="brand_id">Chọn thương hiệu</label><span class="text-danger">*</span>
                                <select class="form-control select2 {{ $errors->has('brand_id')?"is-invalid":"" }}" name="brand_id"
                                    data-placeholder="Chọn thương hiệu" id="brand_id" style="width: 100%;" >
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $brand->id == $data->brand_id?"selected":"" }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('brand_id'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('brand_id') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('product.show', $data->id) }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

</x-layouts.main>
