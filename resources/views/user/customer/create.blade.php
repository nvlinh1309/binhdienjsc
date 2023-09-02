<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Khách hàng</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Khách hàng</a></li>
                            <li class="breadcrumb-item active">Tạo mới</li>
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
        @if (\Session::has('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {!! \Session::get('error') !!}
            </div>
        @endif
    </div>
    <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thêm khách hàng mới</h3>
            </div>

            <form id="quickForm" action="{{ route('customer.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="code">Mã khách hàng</label><span class="text-danger">*</span>
                                <input type="text" name="code" value="{{ old('code') }}"
                                    class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" id="code"
                                    placeholder="Nhập mã khách hàng...">
                                @if ($errors->has('code'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('code') }}</div>
                                @endif
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Tên khách hàng</label><span class="text-danger">*</span>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                                    placeholder="Nhập tên khách hàng...">
                                @if ($errors->has('name'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tax_code">Mã số thuế</label><span class="text-danger">*</span>
                                <input type="text" name="tax_code" value="{{ old('tax_code') }}"
                                    class="form-control {{ $errors->has('tax_code') ? 'is-invalid' : '' }}" id="tax_code"
                                    placeholder="Nhập mã số thuế...">
                                @if ($errors->has('tax_code'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('tax_code') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tax">Thuế suất</label><span class="text-danger">*</span>
                                <input type="number" min="0" max="100" name="tax" value="{{ old('tax') }}"
                                    class="form-control {{ $errors->has('tax') ? 'is-invalid' : '' }}" id="tax"
                                    placeholder="Nhập thuế suất...">
                                @if ($errors->has('tax'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('tax') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="address">Địa chỉ</label><span class="text-danger">*</span>
                                <input type="text" name="address" value="{{ old('address') }}"
                                    class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address"
                                    placeholder="Nhập địa chỉ...">
                                @if ($errors->has('address'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Email</label><span class="text-danger">*</span>
                                <input type="text" name="contact_email" value="{{ old('contact_email') }}"
                                    class="form-control {{ $errors->has('contact_email') ? 'is-invalid' : '' }}"
                                    id="email" placeholder="Nhập email...">
                                @if ($errors->has('contact_email'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('contact_email') }}</div>
                                @endif
                            </div>
                        </div>
                     
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="phone">Điện thoại</label><span class="text-danger">*</span>
                                <input type="text" name="contact_phone" value="{{ old('contact_phone') }}"
                                    class="form-control {{ $errors->has('contact_phone') ? 'is-invalid' : '' }}"
                                    id="phone" placeholder="Nhập số điện thoại...">
                                @if ($errors->has('contact_phone'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('contact_phone') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('customer.index') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

</x-layouts.main>
