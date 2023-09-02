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
        <!-- jquery validation -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cập nhật thông tin nhà cung cấp <strong>{{ $data->name }}</strong></h3>
            </div>

            <form id="update" action="{{ route('supplier.update', $data->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" value="{{$data->id}}" name="id"/>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="supplier_code">Mã nhà cung cấp</label><span class="text-danger">*</span>
                                <input type="text" name="supplier_code" value="{{ old('supplier_code', $data->supplier_code) }}"
                                    class="form-control" id="supplier_code" placeholder="Nhập mã nhà cung cấp...">
                                @if ($errors->has('supplier_code'))
                                    <div class="error text-danger">{{ $errors->first('supplier_code') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name">Tên công ty</label><span class="text-danger">*</span>
                                <input type="text" name="name" value="{{ old('name', $data->name) }}" class="form-control"
                                    id="name" placeholder="Nhập công ty...">
                                @if ($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="contract_signing_date">Ngày ký hợp đồng<span class="text-danger">*</span></label>
                                <input value="{{ old('contract_signing_date', $data->contract_signing_date) }}" type="date"
                                    class="form-control datepicker" name="contract_signing_date" id="contract_signing_date"
                                     placeholder="dd-mm-yyyy">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="address">Địa chỉ</label><span class="text-danger">*</span>
                                <input type="text" name="address" value="{{ old('address', $data->address) }}" class="form-control"
                                    id="address" placeholder="Nhập địa chỉ...">
                                @if ($errors->has('address'))
                                    <div class="error text-danger">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tax_code">Mã số thuế</label><span class="text-danger">*</span>
                                <input type="text" name="tax_code" value="{{ old('tax_code', $data->tax_code) }}"
                                    class="form-control" id="tax_code" placeholder="Nhập mã số thuế">
                                @if ($errors->has('tax_code'))
                                    <div class="error text-danger">{{ $errors->first('tax_code') }}</div>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('supplier.show', $data->id) }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

</x-layouts.main>
