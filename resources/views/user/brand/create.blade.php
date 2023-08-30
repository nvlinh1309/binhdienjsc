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
                            <li class="breadcrumb-item active">Tạo mới</li>
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
                <h3 class="card-title">Thêm nhà cung cấp mới</h3>
            </div>

            <form id="quickForm" action="{{ route('brand.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Tên thương hiệu</label><span class="text-danger">*</span>
                                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}"
                                    placeholder="Nhập tên thương hiệu...">
                                @if ($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Chọn nhà cung cấp</label><span class="text-danger">*</span>
                                <select class="form-control select2" name="supplier_id[]" multiple="multiple"
                                    data-placeholder="Chọn nhà cung cấp" style="width: 100%;">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('supplier_id'))
                                    <div class="error text-danger">{{ $errors->first('supplier_id') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('brand.index') }}" class="btn btn-secondary">Huỷ</a>

                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

</x-layouts.main>
