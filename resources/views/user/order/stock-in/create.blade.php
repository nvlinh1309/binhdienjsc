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

            <form id="quickForm" action="{{ route('stock-in.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_code">Mã Nhập kho</label>
                                <input type="text" name="order_code" class="form-control" id="order_code" required
                                    placeholder="Nhập mã đơn hàng...">
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Chọn nhà cung cấp</label>
                                <select class="form-control select2" name="order_supplier" id="order_supplier"
                                    style="width: 100%;">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_contract_no">Chứng từ (Mã hợp đồng,v.v...)</label>
                                <input type="text" name="order_contract_no" class="form-control"
                                    id="order_contract_no" placeholder="Nhập mã đơn hàng...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_wh">Chọn kho</label>
                                <select class="form-control select2" name="order_wh" style="width: 100%;">
                                    @foreach ($wareHouses as $wareHouse)
                                        <option value="{{ $wareHouse->id }}">{{ $wareHouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="order_date_manufacture">Ngày nhập kho</label>
                            <input type="text" class="form-control datepicker" name="receipt_date" id=""
                                data-provide="datepicker">
                        </div>

                        <div class="col-sm-12">
                            <label for="order_code">Sản Phẩm</label>
                        </div>
                        <div class="col-sm-12">
                            <div class="card" id="containerProduct">
                                <div class="form-row mr-0 ml-0">
                                    <div class="form-group col-md-3 div-add-prod">
                                        <label for="order_product_1">Chọn Sản Phẩm</label>
                                        <select name="order_product_1" class="form-control select2" required>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="order_date_manufacture">Nhập số lượng</label>
                                        <input type="text" class="form-control" name="order_quantity_1" required
                                            placeholder="Nhập số lượng...">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="order_date_manufacture">Ngày Sản Xuất</label>
                                        <input type="text" class="form-control datepicker"
                                            name="order_date_manufacture_1" data-provide="datepicker">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="input_expDate">Hạn Sử Dụng</label>
                                        <input type="text" class="form-control datepicker" name="input_expDate_1"
                                            id="input_expDate" data-provide="datepicker">
                                    </div>

                                </div>
                                <!-- /.card-header -->
                                <!-- /.card-body -->

                            </div>
                            <div class="form-group col-md-3">
                                <button type="button" id="addProduct" class="btn btn-secondary">Thêm Sản Phẩm</button>
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

    <script>
        jQuery(document).on('focus', ".datepicker", function() {
            jQuery(this).datepicker({
                format: 'yyyy-mm-dd'
            });
        });
        $(document).ready(function() {

            $('#addProduct').on('click', function(e) {
                var array = {!! json_encode($products) !!};
                var options;
                console.log(array);
                $.each(array, function(key, value) {
                    options = options + '<option value="' + value.id + '">' + value.name +
                        '</option>';
                });
                var numItems = $('.div-add-prod').length
                var newNumItems = numItems + 1;
                var structure = '<div class="form-row mr-0 ml-0 div-add-prod">' +
                    '<div class="form-group col-md-3">' +
                    '<label for="inputState">Chọn Sản Phẩm</label>' +
                    '<select name="order_product_' + newNumItems + '" class="form-control select2">' +
                    options;
                structure += '</select>' +
                    '</div>' +
                    '<div class="form-group col-md-2">' +
                    '<label for="order_date_manufacture">Nhập số lượng</label>' +
                    '<input type="text" class="form-control" name="order_quantity_' + newNumItems +
                    '" placeholder="Nhập số lượng..." required>' +
                    '</div>' +
                    '<div class="form-group col-md-3">' +
                    '<label for="inputCity">Ngày Sản Xuất</label>' +
                    '<input type="text" class="form-control datepicker" name="order_date_manufacture_' +
                    newNumItems + '" data-provide="datepicker">' +
                    '</div>' +
                    '<div class="form-group col-md-3">' +
                    '<label for="inputZip">Hạn Dùng</label>' +
                    '<input type="text" class="form-control datepicker"  name="input_expDate_' +
                    newNumItems + '" data-provide="datepicker">' +
                    '</div>' +
                    '<div class="form-group col-md-1 align-self-center d-flex justify-content-center mb-0 div-product">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash delete-product" viewBox="0 0 16 16">' +
                    '<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />' +
                    '<path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />' +
                    '</div>' +
                    '</svg>' +
                    '</div>';
                $("#containerProduct").append(structure);
            });

            $('#containerProduct').on('click', '.delete-product', function() {
                $(this).parent().parent().remove();
            });
        });
    </script>
</x-layouts.main>
