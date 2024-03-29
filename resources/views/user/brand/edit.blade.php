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
        <!-- jquery validation -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cập nhật thương hiệu <strong>{{ $data->name }}</strong></h3>
            </div>

            <form id="update" action="{{ route('brand.update', $data->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" value="{{$data->id}}" name="id"/>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Tên thương hiệu</label><span class="text-danger">*</span>
                                <input type="text" name="name" value="{{ old('name', $data->name) }}" class="form-control {{ $errors->has('name')?"is-invalid":"" }}"
                                    id="name" placeholder="Nhập tên thương hiệu...">
                                    @if ($errors->has('name'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('name') }}</div>
                                @endif
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Chọn nhà cung cấp</label><span class="text-danger">*</span>
                                <select class="form-control select2 brand_supplier_select {{ $errors->has('supplier_id')?"is-invalid":"" }}" name="supplier_id[]" multiple="multiple" data-placeholder="Chọn nhà cung cấp" style="width: 100%;">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('supplier_id'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('supplier_id') }}</div>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('brand.show', $data->id) }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
    @section('script')
        <script>
            // $('brand_supplier_select').select2().val(['3', '2']).trigger('change')

            $(".brand_supplier_select").val({!! json_encode($data->suppliers()->allRelatedIds()) !!}).trigger("change");
        </script>
    @stop
</x-layouts.main>

