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
                            <li class="breadcrumb-item active">Thêm nhà cung cấp</li>
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

            <form id="quickForm" action="{{ route('supplier.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="supplier_code">Mã nhà cung cấp</label><span class="text-danger">*</span>
                                <input type="text" name="supplier_code"
                                    class="form-control {{ $errors->has('supplier_code') ? 'is-invalid' : '' }}"
                                    value="{{ old('supplier_code') }}" id="supplier_code"
                                    placeholder="Nhập mã nhà cung cấp...">
                                @if ($errors->has('supplier_code'))
                                    <div class="error text-danger invalid-feedback-custom">
                                        {{ $errors->first('supplier_code') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name">Tên công ty</label><span class="text-danger">*</span>
                                <input type="text" name="name"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                                    value="{{ old('name') }}" placeholder="Nhập tên công ty...">
                                @if ($errors->has('name'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="contract_signing_date">Ngày ký hợp đồng<span
                                        class="text-danger">*</span></label>
                                <input value="{{ old('contract_signing_date') }}" type="text"
                                    data-provide="datepicker"
                                    class="form-control datepicker {{ $errors->has('contract_signing_date') ? 'is-invalid' : '' }}"
                                    name="contract_signing_date" id="contract_signing_date" placeholder="">
                                @if ($errors->has('contract_signing_date'))
                                    <div class="error text-danger invalid-feedback-custom">
                                        {{ $errors->first('contract_signing_date') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="address">Địa chỉ</label><span class="text-danger">*</span>
                                <input type="text" name="address"
                                    class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address"
                                    value="{{ old('address') }}" placeholder="Nhập địa chỉ...">
                                @if ($errors->has('address'))
                                    <div class="error text-danger invalid-feedback-custom">
                                        {{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tax_code">Mã số thuế</label><span class="text-danger">*</span>
                                <input type="text" name="tax_code"
                                    class="form-control {{ $errors->has('tax_code') ? 'is-invalid' : '' }}" id="tax_code"
                                    value="{{ old('tax_code') }}" placeholder="Nhập mã số thuế...">
                                @if ($errors->has('tax_code'))
                                    <div class="error text-danger invalid-feedback-custom">
                                        {{ $errors->first('tax_code') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

</x-layouts.main>
