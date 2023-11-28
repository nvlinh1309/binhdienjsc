<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Đơn mua (Nhập kho)</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('stock-in.index') }}">Đơn mua (Nhập kho)</a></li>
                            <li class="breadcrumb-item active">Khởi tạo đơn hàng</li>
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
                <h3 class="card-title">Khởi tạo đơn hàng</h3>
            </div>

            <form id="quickForm" action="{{ route('order-buyer.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="code">Mã đặt hàng<span class="text-danger">*</span></label>
                                <input value="{{ old('code') }}" type="text" name="code"
                                    class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" id="code"
                                    placeholder="Nhập mã đặt hàng..."
                                    {{ $errors->has('code') ? 'aria-describedby="order_code-error" aria-invalid="true"' : '' }}>
                                @if ($errors->has('code'))
                                    <span id="code-error"
                                        class="error invalid-feedback">{{ $errors->first('code') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="approved_by">Người duyệt đơn đặt hàng<span
                                        class="text-danger">*</span></label>
                                <select class="form-control select2" name="approved_by" id="approved_by"
                                    style="width: 100%;">
                                    @foreach ($managers as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == old('approved_by') ? 'selected' : '' }}>
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Chọn nhà cung cấp<span class="text-danger">*</span></label>
                                <select class="form-control select2" name="supplier_id" id="supplier_id"
                                    style="width: 100%;">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ $supplier->id == old('supplier_id') ? 'selected' : '' }}>
                                            {{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="estimated_delivery_time">Thời gian dự kiến giao hàng<span
                                        class="text-danger">*</span></label>
                                <input value="{{ old('estimated_delivery_time') }}" type="text"
                                    name="estimated_delivery_time" class="form-control" id="estimated_delivery_time"
                                    placeholder="Nhập thời gian dự kiến giao hàng...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="storage_id">Kho nhận hàng:<span class="text-danger">*</span></label>
                                <select class="form-control select2" name="storage_id" id="storage_id"
                                    style="width: 100%;">
                                    @foreach ($storages as $storage)
                                        <option value="{{ $storage->id }}"
                                            {{ $storage->id == old('storage_id') ? 'selected' : '' }}>
                                            {{ $storage->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info"></i> Thông tin đơn vị mua hàng</h5>
                                <hr>
                                <div class="form-group">
                                    <label for="company_name">Tên công ty<span class="text-danger">*</span></label>
                                    <input value="{{ $companyInfo['name'] }}" type="text" name="company_name"
                                        class="form-control" id="company_name" placeholder="Nhập tên công ty...">
                                </div>
                                <div class="form-group">
                                    <label for="company_address">Địa chỉ<span class="text-danger">*</span></label>
                                    <input value="{{ $companyInfo['address'] }}" type="text" name="company_address"
                                        class="form-control" id="company_address" placeholder="Nhập địa chỉ...">
                                </div>
                                <div class="form-group">
                                    <label for="company_tax">Mã số thuế<span class="text-danger">*</span></label>
                                    <input value="{{ $companyInfo['tax_code'] }}" type="text"
                                        name="company_tax" class="form-control" id="company_tax"
                                        placeholder="Nhập mã số thuế...">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Lưu và tiếp tục</button>
                </div>

            </form>
        </div>
        <!-- /.card -->
    </div>


    <script>
        $(function() {
            if ($("#quickForm").length > 0) {
                $('#quickForm').validate({
                    rules: {
                        code: {
                            required: true,
                        },
                        approved_by: {
                            required: true
                        },
                        supplier_id: {
                            required: true
                        },
                        estimated_delivery_time: {
                            required: true
                        },
                        company_name: {
                            required: true
                        },
                        company_address: {
                            required: true
                        },
                        company_tax: {
                            required: true
                        }
                    },
                    messages: {
                        code: {
                            required: "Vui lòng nhập mã đơn đặt hàng"
                        },
                        estimated_delivery_time: {
                            required: "Vui lòng nhập thời gian dự kiến giao hàng",
                        },
                        approved_by: {
                            required: "Người duyệt đơn chưa được chọn",
                        },
                        supplier_id: {
                            required: "Nhà cung cấp chưa được chọn",
                        },
                        company_name: {
                            required: "Vui lòng nhập tên công ty",
                        },
                        company_address: {
                            required: "Vui lòng nhập địa chỉ",
                        },
                        company_tax: {
                            required: "Vui lòng nhập mã số thuế",
                        }
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            }
        });
    </script>
</x-layouts.main>
