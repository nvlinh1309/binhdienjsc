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
                            <li class="breadcrumb-item active">Chỉnh sửa đơn mua (nhập kho)</li>
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
                <h3 class="card-title">Cập nhật đơn mua (nhập kho) với mã nhập kho:
                    {{ $goodReceiptManagement->goods_receipt_code }}</h3>
            </div>

            <form id="quickForm" action="{{ route('stock-in.update', $goodReceiptManagement->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_code">Mã Nhập kho</label>
                                <input type="text" name="order_code" class="form-control"
                                    value="{{ old('order_code', $goodReceiptManagement->goods_receipt_code) }}"
                                    id="order_code" placeholder="Nhập mã đơn hàng...">
                                @if ($errors->has('order_code'))
                                    <div class="error text-danger">{{ $errors->first('order_code') }}</div>
                                @endif
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Chọn nhà cung cấp</label>
                                <select class="form-control select2" name="order_supplier" id="order_supplier"
                                    style="width: 100%;">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ $supplier->id == old('order_supplier', $goodReceiptManagement->supplier_id) ? 'selected' : '' }}>
                                            {{ $supplier->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_contract_no">Chứng từ (Mã hợp đồng,v.v...)</label>
                                <input type="text" name="order_contract_no" class="form-control"
                                    id="order_contract_no"
                                    value="{{ old('order_contract_no', $goodReceiptManagement->document) }}"
                                    placeholder="Nhập mã đơn hàng...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_wh">Chọn kho</label>
                                <select class="form-control select2" name="order_wh" style="width: 100%;">
                                    @foreach ($wareHouses as $wareHouse)
                                        {{-- @if (old('order_wh')) --}}
                                        <option value="{{ $wareHouse->id }}"
                                            {{ $wareHouse->id == old('order_wh', $goodReceiptManagement->storage_id) ? 'selected' : '' }}>
                                            {{ $wareHouse->name }}</option>
                                        {{-- @else
                                            <option value="{{ $wareHouse->id }}"
                                                {{ $wareHouse->id == $goodReceiptManagement->storage_id ? 'selected' : '' }}>
                                                {{ $wareHouse->name }}</option> --}}
                                        {{-- @endif --}}
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="order_date_manufacture">Ngày nhập kho</label>
                            <input type="text" class="form-control datepicker"
                                value="{{ old('receipt_date', $goodReceiptManagement->receipt_date?$goodReceiptManagement->receipt_date->format('d-m-Y'):'') }}"
                                {{-- value="{{ old('receipt_date') ? old('receipt_date') : ($goodReceiptManagement->receipt_date ? $goodReceiptManagement->receipt_date->format('d-m-Y') : '') }}" --}} name="receipt_date" id="" data-provide="datepicker">
                        </div>

                        <div class="col-sm-4">
                            <label for="order_date_manufacture">Thông tin giao nhận</label>
                            <textarea class="form-control" name="receive_info"
                                value="{{ old('receive_info', $goodReceiptManagement->receive_info) }}" rows="1">{{ old('receive_info', $goodReceiptManagement->receive_info) }}</textarea>
                        </div>

                        <div class="col-sm-4">
                            <label for="receive_cont">Xe/Cont</label>
                            <textarea class="form-control" name="receive_cont"
                                value="{{ old('receive_cont', $goodReceiptManagement->receive_cont) }}" rows="1">{{ old('receive_cont', $goodReceiptManagement->receive_cont) }}</textarea>
                        </div>

                        <div class="col-sm-4 mt-3">
                            <label for="receipt_status">Trạng thái đơn hàng</label>
                            <select class="form-control select2" name="receipt_status" style="width: 100%;">
                                @foreach ($statusList as $keyStatus => $status)
                                    @if($status != 'Đã phê duyệt' || ($status == 'Đã phê duyệt' && \Auth::user()->hasRole('manager')))
                                    <option value="{{ $keyStatus }}"
                                        {{ $keyStatus == old('receipt_status', $goodReceiptManagement->receipt_status) ? 'selected' : '' }}>
                                        {{ $status }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-4 mt-3">
                            <label for="approval_user">Phê duyệt lệnh mua</label>
                            <select class="form-control select2" name="approval_user" style="width: 100%;">
                                @foreach ($dataUser as $userDetail)
                                    <option value="{{ $userDetail->id }}"
                                        {{ $userDetail->id == old('approval_user', $goodReceiptManagement->approval_user) ? 'selected' : '' }}>
                                        {{ $userDetail->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-4 mt-3">
                            <div class="form-group">
                                <label for="receive_user">Bộ phận giao nhận</label>
                                <select class="form-control select2" name="receive_user" style="width: 100%;">
                                    @foreach ($dataUser as $userDetail)
                                        <option value="{{ $userDetail->id }}"
                                            {{ $userDetail->id == old('receive_user', $goodReceiptManagement->receive_user) ? 'selected' : '' }}>
                                            {{ $userDetail->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="wh_user">Thủ kho hàng</label>
                                <select class="form-control select2" name="wh_user" style="width: 100%;">
                                    @foreach ($dataUser as $userDetail)
                                        <option value="{{ $userDetail->id }}"
                                            {{ $userDetail->id == old('wh_user', $goodReceiptManagement->wh_user) ? 'selected' : '' }}>
                                            {{ $userDetail->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="sales_user">Phụ trách tổ kinh doanh</label>
                                <select class="form-control select2" name="sales_user" style="width: 100%;">
                                    @foreach ($dataUser as $userDetail)
                                        <option value="{{ $userDetail->id }}"
                                            {{ $userDetail->id == old('sales_user', $goodReceiptManagement->sales_user) ? 'selected' : '' }}>
                                            {{ $userDetail->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <label for="order_code">Sản Phẩm</label>
                        </div>
                        <div class="col-sm-12">
                            <div class="card" id="containerProduct">
                                <?php
                                $dataOld = session()->getOldInput();
                                $dataOldProduct = [];
                                if (count($dataOld) > 0) {
                                    foreach ($dataOld as $key => $value) {
                                        if (strpos($key, 'order_product_') !== false) {
                                            $arrayTemp = explode('_', $key);
                                            array_push($dataOldProduct, $arrayTemp[2]);
                                        }
                                    }
                                }
                                ?>

                                <?php $countt = 1; ?>
                                @if (count($productsGoodReceipt) > 0)
                                    @foreach ($productsGoodReceipt as $key => $productReceipt)
                                        @if ($countt == 1 || count($dataOldProduct) == 0)
                                            <div class="form-row mr-0 ml-0 div-add-prod">
                                                <div class="form-group col-md-3">
                                                    <label for="order_product_1">Chọn Sản Phẩm</label>
                                                    <select name="order_product_{{ $countt }}"
                                                        class="form-control select2">
                                                        @foreach ($products as $product)
                                                            @if (old('order_product_' . $countt))
                                                                <option value="{{ $product->id }}"
                                                                    {{ $product->id == old('order_product_' . $countt) ? 'selected' : '' }}>
                                                                    {{ $product->name }}</option>
                                                            @else
                                                                <option value="{{ $product->id }}"
                                                                    {{ $product->id == $productReceipt->product_id ? 'selected' : '' }}>
                                                                    {{ $product->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="order_date_manufacture">Nhập số lượng</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('order_quantity_' . $countt, $productReceipt->quantity) }}"
                                                        name="order_quantity_{{ $countt }}"
                                                        placeholder="Nhập số lượng...">
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="order_date_manufacture">Ngày Sản Xuất</label>
                                                    <input type="text" class="form-control datepicker"
                                                        name="order_date_manufacture_{{ $countt }}"
                                                        data-provide="datepicker"
                                                        value="{{ old('order_date_manufacture_' . $countt, $productReceipt->date_of_manufacture ? $productReceipt->date_of_manufacture->format('d-m-Y') : '') }}"
                                                        {{-- value="{{ old('order_date_manufacture_' . $countt) ?? (old('order_date_manufacture_' . $countt) ?? ($productReceipt->date_of_manufacture ? $productReceipt->date_of_manufacture->format('d-m-Y') : '')) }}" --}}>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="input_expDate">Hạn Sử Dụng</label>
                                                    <input type="text" class="form-control datepicker"
                                                        name="input_expDate_{{ $countt }}" id="input_expDate"
                                                        data-provide="datepicker"
                                                        value="{{ old('input_expDate_' . $countt, $productReceipt->expiry_date ? $productReceipt->expiry_date->format('d-m-Y') : '') }}"
                                                        {{-- value="{{ old('input_expDate_' . $countt) ?? (old('input_expDate_' . $countt) ?? ($productReceipt->expiry_date ? $productReceipt->expiry_date->format('d-m-Y') : '')) }}" --}}>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="note_product_{{ $countt }}">Ghi chú</label>
                                                    <textarea class="form-control" id="note_product_{{ $countt }}" name="note_product_{{ $countt }}"
                                                        rows="1">{{ old('note_product_' . $countt, $productReceipt->note_product) }}</textarea>
                                                </div>
                                                @if ($countt > 1)
                                                    <div
                                                        class="form-group col-md-1 align-self-center d-flex justify-content-center mb-0 div-product">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-trash delete-product" viewBox="0 0 16 16">
                                                            <path
                                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                            <path
                                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        <?php $countt++; ?>
                                    @endforeach
                                @else
                                    <div class="form-row mr-0 ml-0">
                                        <div class="form-group col-md-3 div-add-prod">
                                            <label for="order_product_1">Chọn Sản Phẩm</label>
                                            <select name="order_product_1" class="form-control select2">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="order_date_manufacture">Nhập số lượng</label>
                                            <input type="text" class="form-control" name="order_quantity_1"
                                                placeholder="Nhập số lượng...">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="order_date_manufacture">Ngày Sản Xuất</label>
                                            <input type="text" class="form-control datepicker"
                                                name="order_date_manufacture_1" data-provide="datepicker">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="input_expDate">Hạn Sử Dụng</label>
                                            <input type="text" class="form-control datepicker"
                                                name="input_expDate_1" id="input_expDate" data-provide="datepicker">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="note_product_1">Ghi chú</label>
                                            <textarea class="form-control" id="note_product_1" name="note_product_1" rows="1">{{ old('note_product_1') }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if (count($dataOldProduct) > 0)
                                    <?php $newIndex = 2; ?>
                                    <?php unset($dataOldProduct[0]); ?>
                                    @foreach ($dataOldProduct as $index)
                                        <div class="form-row mr-0 ml-0 div-add-prod">
                                            <div class="form-group col-md-3">
                                                <label for="order_product_{{ $newIndex }}">Chọn Sản Phẩm</label>
                                                <select name="order_product_{{ $newIndex }}"
                                                    class="form-control select2">
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}"
                                                            {{ $product->id == old('order_product_' . $index) ? 'selected' : '' }}>
                                                            {{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="order_date_manufacture">Nhập số lượng</label>
                                                <input type="text" value="{{ old('order_quantity_' . $index) }}"
                                                    class="form-control" name="order_quantity_{{ $newIndex }}"
                                                    placeholder="Nhập số lượng...">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="order_date_manufacture">Ngày Sản Xuất</label>
                                                <input type="text"
                                                    value="{{ old('order_date_manufacture_' . $index) }}"
                                                    class="form-control datepicker"
                                                    name="order_date_manufacture_{{ $newIndex }}"
                                                    data-provide="datepicker">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="input_expDate">Hạn Sử Dụng</label>
                                                <input type="text" value="{{ old('input_expDate_' . $index) }}"
                                                    class="form-control datepicker"
                                                    name="input_expDate_{{ $newIndex }}" id="input_expDate"
                                                    data-provide="datepicker">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="note_product">Ghi chú</label>
                                                <textarea class="form-control" name="note_product_{{ $newIndex }}" rows="1">{{ old('note_product_' . $index) }}</textarea>
                                            </div>
                                            <div
                                                class="form-group col-md-1 align-self-center d-flex justify-content-center mb-0 div-product">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-trash delete-product"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                    <path
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <?php $newIndex++; ?>
                                    @endforeach

                                @endif
                                <!-- /.card-header -->
                                <!-- /.card-body -->

                            </div>
                            <div class="form-group col-md-3">
                                <button type="button" id="addProduct" class="btn btn-secondary">Thêm Sản
                                    Phẩm</button>
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
                format: 'dd-mm-yyyy'
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
                    '" placeholder="Nhập số lượng...">' +
                    '</div>' +
                    '<div class="form-group col-md-2">' +
                    '<label for="inputCity">Ngày Sản Xuất</label>' +
                    '<input type="text" class="form-control datepicker" name="order_date_manufacture_' +
                    newNumItems + '" data-provide="datepicker">' +
                    '</div>' +
                    '<div class="form-group col-md-2">' +
                    '<label for="inputZip">Hạn Dùng</label>' +
                    '<input type="text" class="form-control datepicker"  name="input_expDate_' +
                    newNumItems + '" data-provide="datepicker">' +
                    '</div>' +
                    '<div class="form-group col-md-2">' +
                    '<label for="note_product_' + newNumItems + '">Ghi chú</label>' +
                    '<textarea class="form-control" id="note_product_' + newNumItems +
                    '" name="note_product_' + newNumItems + '" rows="1">' +
                    '</textarea>' +
                    '</div>' +
                    '<div class="form-group col-md-1 align-self-center d-flex justify-content-center mb-0 div-product">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash delete-product" viewBox="0 0 16 16">' +
                    '<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />' +
                    '<path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />' +
                    '</svg>' +
                    '</div>' +
                    '</div>';
                $("#containerProduct").append(structure);
            });

            $('#containerProduct').on('click', '.delete-product', function() {
                $(this).parent().parent().remove();
            });
        });
    </script>
</x-layouts.main>
