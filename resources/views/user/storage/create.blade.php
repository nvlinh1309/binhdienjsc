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
                            <li class="breadcrumb-item"><a href="{{ route('store.index') }}">Kho</a></li>
                            <li class="breadcrumb-item active">Thêm kho mới</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    @stop()

    <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thêm kho mới</h3>
            </div>

            <form id="quickForm" action="{{ route('store.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="code">Mã kho</label><span class="text-danger">*</span>
                                <input type="text" name="code" class="form-control {{ $errors->has('code')?"is-invalid":"" }}" id="code" value="{{ old('code') }}"
                                    placeholder="Nhập mã kho...">
                                @if ($errors->has('code'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('code') }}</div>
                                @endif
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Tên kho</label><span class="text-danger">*</span>
                                <input type="text" name="name" class="form-control {{ $errors->has('name')?"is-invalid":"" }}" id="name" value="{{ old('name') }}"
                                    placeholder="Nhập tên kho...">
                                @if ($errors->has('name'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="address">Địa chỉ</label><span class="text-danger">*</span>
                                <input type="text" name="address" class="form-control {{ $errors->has('address')?"is-invalid":"" }}" id="address" value="{{ old('address') }}"
                                    placeholder="Nhập địa chỉ kho...">
                                @if ($errors->has('address'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('store.index') }}" class="btn btn-secondary">Huỷ bỏ</a>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

</x-layouts.main>
