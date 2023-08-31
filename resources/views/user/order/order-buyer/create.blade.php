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
                            <li class="breadcrumb-item active">Tạo đơn hàng</li>
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="code">Mã đặt hàng<span class="text-danger">*</span></label>
                                <input value="{{ old('code') }}" type="text" name="code"
                                    class="form-control {{ $errors->has('code')?"is-invalid":"" }}" id="code" placeholder="Nhập mã đặt hàng..." {{ $errors->has('code')?'aria-describedby="order_code-error" aria-invalid="true"':''}}>
                                    @if ($errors->has('code'))
                                        <span id="code-error" class="error invalid-feedback">{{ $errors->first('code') }}</span>
                                    @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="estimate_delivery_time">Thời gian dự kiến giao hàng<span class="text-danger">*</span></label>
                                <input value="{{ old('estimate_delivery_time') }}" type="text"
                                    name="estimate_delivery_time" class="form-control" id="order_contract_no"
                                    placeholder="Nhập thời gian dự kiến giao hàng...">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="storage_id">Chọn kho nhập hàng<span class="text-danger">*</span></label>
                                <select class="form-control select2" name="storage_id" style="width: 100%;">
                                    @foreach ($wareHouses as $wareHouse)
                                        <option value="{{ $wareHouse->id }}"
                                            {{ $wareHouse->id == old('storage_id') ? 'selected' : '' }}>
                                            {{ $wareHouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="order_date_manufacture">Ngày đặt hàng<span class="text-danger">*</span></label>
                                <input value="{{ old('receipt_date', now()->format('d-m-Y')) }}" type="text"
                                    class="form-control datepicker" name="receipt_date" id="receipt_date"
                                    data-provide="datepicker" placeholder="dd-mm-yyyy">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info"></i> Thông tin đơn vị mua hàng</h5>
                                <hr>
                                <div class="form-group">
                                    <label for="buyer_name">Tên công ty<span class="text-danger">*</span></label>
                                    <input value="{{ $companyInfo['name'] }}" type="text" name="buyer_name"
                                        class="form-control" id="buyer_name" placeholder="Nhập tên công ty...">
                                </div>
                                <div class="form-group">
                                    <label for="buyer_address">Địa chỉ<span class="text-danger">*</span></label>
                                    <input value="{{ $companyInfo['address'] }}" type="text" name="buyer_address"
                                        class="form-control" id="buyer_address" placeholder="Nhập địa chỉ...">
                                </div>
                                <div class="form-group">
                                    <label for="buyer_tax_code">Mã số thuế<span class="text-danger">*</span></label>
                                    <input value="{{ $companyInfo['tax_code'] }}" type="text" name="buyer_tax_code"
                                        class="form-control" id="buyer_tax_code" placeholder="Nhập mã số thuế...">
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-md-12">
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info"></i> Sản phẩm đặt hàng</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" id="containerProduct">
                                            <div class="form-row mr-0 ml-0 div-add-prod">
                                                <div class="form-group col-md-8">
                                                    <label for="order_product_1">Chọn Sản Phẩm<span class="text-danger">*</span></label>
                                                    <select name="order_product_1" class="form-control select2">
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                {{ $product->id == old('order_product_1') ? 'selected' : '' }}>
                                                                {{ $product->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="order_date_manufacture">Nhập số lượng <span class="text-danger">*</span></label>
                                                    <input type="text" value="{{ old('order_quantity_1') }}"
                                                        class="form-control" name="order_quantity_1"
                                                        placeholder="Nhập số lượng...">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="order_date_manufacture">Ngày Sản Xuất</label>
                                                    <input type="text"
                                                        value="{{ old('order_date_manufacture_1') }}"
                                                        class="form-control datepicker"
                                                        name="order_date_manufacture_1" data-provide="datepicker">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="input_expDate">Hạn Sử Dụng</label>
                                                    <input type="text" value="{{ old('input_expDate_1') }}"
                                                        class="form-control datepicker" name="input_expDate_1"
                                                        id="input_expDate" data-provide="datepicker">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="note_product_1">Ghi chú</label>
                                                    <textarea class="form-control" id="note_product_1" name="note_product_1" rows="1">{{ old('note_product_1') }}</textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="btn btn-success btn-sm" id="add_product">Thêm</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="hidden" name="products">
                                                    <div></div>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tên sản phẩm</th>
                                                                <th>Số lượng</th>
                                                                <th>Ngày sản xuất</th>
                                                                <th>Hạn sử dụng</th>
                                                                <th>Ghi chú</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="products">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

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


    <script>
        $(function() {
            $("#add_product").click(function(){
                alert(1);
            })
            if ($("#quickForm").length > 0) {
                $('#quickForm').validate({
                    rules: {
                        code: {
                            required: true,
                        },
                        estimate_delivery_time: {
                            required: true
                        },
                        receipt_date: {
                            required: true
                        },
                        buyer_name: {
                            required: true
                        },
                        buyer_address: {
                            required: true
                        },
                        buyer_tax_code: {
                            required: true
                        },
                        products: {
                            required: true
                        }
                    },
                    messages: {
                        code: {
                            required: "Vui lòng nhập mã đặt hàng"
                        },
                        estimate_delivery_time: {
                            required: "Vui lòng nhập thời gian dự kiến giao hàng",
                        },
                        receipt_date: {
                            required: "Vui lòng nhập ngày đặt hàng",
                        },
                        buyer_name: {
                            required: "Vui lòng nhập tên công ty",
                        },
                        buyer_address: {
                            required: "Vui lòng nhập địa chỉ",
                        },
                        buyer_tax_code: {
                            required: "Vui lòng nhập mã số thuế",
                        },
                        products: {
                            required: "Vui lòng thêm ít nhất 1 sản phẩm"
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

    <script>
        jQuery(document).on('focus', ".datepicker", function() {
            jQuery(this).datepicker({
                format: 'dd-mm-yyyy'
            });
        });
    </script>
</x-layouts.main>
