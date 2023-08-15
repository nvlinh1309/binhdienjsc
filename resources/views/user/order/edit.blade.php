<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Đơn hàng</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Đơn hàng</a></li>
                            <li class="breadcrumb-item active">{{ $order->order_code }}</li>
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
                <h3 class="card-title">Cập nhật thông tin đơn hàng <strong>{{ $order->order_code }}</strong></h3>
            </div>

            <form id="update" action="{{ route('order.update', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" value="{{$order->id}}"/>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_code">Mã đơn hàng</label><span class="text-danger">*</span>
                                <input type="text" name="order_code" class="form-control"
                                    value="{{ old('order_code', $order->order_code) }}" id="order_code"
                                    placeholder="Nhập mã đơn hàng...">
                                @if ($errors->has('order_code'))
                                    <div class="error text-danger">{{ $errors->first('order_code') }}</div>
                                @endif
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Chọn khách hàng</label>
                                <select class="form-control select2" name="customer_id" id="customer_id"
                                    style="width: 100%;" id="customer_id">
                                    {{-- <option selected="selected">Alabama</option> --}}
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ $customer->id == old('customer_id', $order->customer_id) ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="order_contract_no">Chứng từ (Mã hợp đồng,v.v...)</label>
                                <input type="text" name="order_contract_no" class="form-control"
                                    id="order_contract_no" value="{{ old('order_contract_no', $order->document) }}"
                                    placeholder="Nhập mã đơn hàng...">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="order_wh">Chọn kho</label>
                                <select class="form-control select2" id="input_order_wh" name="order_wh"
                                    style="width: 100%;">
                                    @foreach ($wareHouses as $wareHouse)
                                        {{-- @if (old('order_wh')) --}}
                                        <option value="{{ $wareHouse->id }}"
                                            {{ $wareHouse->id == old('order_wh', $order->storage_id) ? 'selected' : '' }}>
                                            {{ $wareHouse->name }}</option>
                                        {{-- @else
                                            <option value="{{ $wareHouse->id }}"
                                                {{ $wareHouse->id == $order->storage_id ? 'selected' : '' }}>
                                                {{ $wareHouse->name }}</option> --}}
                                        {{-- @endif --}}
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label for="payment_method">Hình thức thanh toán</label>
                            <select class="form-control select2" name="payment_method" style="width: 100%;">
                                @foreach ($paymentMethodList as $keyMethod => $nameMethod)
                                    <option value="{{ $keyMethod }}"
                                        {{ $keyMethod == old('payment_method', $order->payment_method) ? 'selected' : '' }}>
                                        {{ $nameMethod }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="order_date_manufacture">Thông tin giao nhận</label>
                            <textarea class="form-control" name="receive_info" value="{{ old('receive_info', $order->receive_info) }}"
                                rows="1">{{ old('receive_info', $order->receive_info) }}</textarea>
                        </div>
                        <div class="col-sm-4">
                            <label for="receive_cont">Xe/Cont</label>
                            <textarea class="form-control" name="receive_cont" value="{{ old('receive_cont', $order->receive_cont) }}"
                                rows="1">{{ old('receive_cont', $order->receive_cont) }}</textarea>
                        </div>

                        <div class="col-sm-4">
                            <label for="order_date_manufacture">Ngày xuất kho</label>
                            <input type="text" class="form-control datepicker"
                                value="{{ old('delivery_date', $order->delivery_date ? $order->delivery_date->format('d-m-Y') : '') }}"
                                name="delivery_date" id="" data-provide="datepicker">
                        </div>

                        <div class="col-sm-4 mt-3">
                            <div class="form-group">
                                <label for="receive_user">Bộ phận giao nhận</label>
                                <select class="form-control select2" name="receive_user" style="width: 100%;">
                                    @foreach ($dataUser as $userDetail)
                                        <option value="{{ $userDetail->id }}"
                                            {{ $userDetail->id == old('receive_user', $order->receive_user) ? 'selected' : '' }}>
                                            {{ $userDetail->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 mt-3">
                            <div class="form-group">
                                <label for="wh_user">Thủ kho hàng</label>
                                <select class="form-control select2" name="wh_user" style="width: 100%;">
                                    @foreach ($dataUser as $userDetail)
                                        <option value="{{ $userDetail->id }}"
                                            {{ $userDetail->id == old('wh_user', $order->wh_user) ? 'selected' : '' }}>
                                            {{ $userDetail->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 mt-3">
                            <div class="form-group">
                                <label for="sales_user">Phụ trách tổ kinh doanh</label>
                                <select class="form-control select2" name="sales_user" style="width: 100%;">
                                    @foreach ($dataUser as $userDetail)
                                        <option value="{{ $userDetail->id }}"
                                            {{ $userDetail->id == old('sales_user', $order->sales_user) ? 'selected' : '' }}>
                                            {{ $userDetail->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 mt-3">
                            <label for="order_status">Trạng thái đơn hàng</label>
                            <select class="form-control select2" name="order_status" style="width: 100%;">
                                @foreach ($statusList as $keyStatus => $status)
                                    @if ($status != 'Đã phê duyệt' || ($status == 'Đã phê duyệt' && \Auth::user()->hasRole('manager')))
                                        <option value="{{ $keyStatus }}"
                                            {{ $keyStatus == old('order_status', $order->order_status) ? 'selected' : '' }}>
                                            {{ $status }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-4 mt-3">
                            <label for="approval_user">Phê duyệt đơn bán</label>
                            <select class="form-control select2" name="approval_user" style="width: 100%;">
                                @foreach ($dataUser as $userDetail)
                                    <option value="{{ $userDetail->id }}"
                                        {{ $userDetail->id == old('approval_user', $order->approval_user) ? 'selected' : '' }}>
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
                            @if (count($order->order_detail) > 0)
                                @foreach ($order->order_detail as $key => $productDetail)
                                    @if (count($dataOldProduct) == 0 && count($dataOld) == 0)
                                        <div class="form-row mr-0 ml-0 div-add-prod">
                                            <div class="form-group col-md-4">
                                                <label for="order_product_{{ $countt }}">Chọn Sản
                                                    Phẩm</label><span class="text-danger">*</span>
                                                <select name="order_product_{{ $countt }}"
                                                    class="form-control select2">
                                                    @foreach ($productL as $keyP => $product)
                                                        <option value="{{ $keyP . '_' . $product['price'] }}"
                                                            {{ $keyP . '_' . $product['price'] == $productDetail->product_id . '_' . $productDetail->price ? 'selected' : '' }}>
                                                            {{ $product['name'] . ' - Giá ' . $product['price'] . ' - Số lượng còn lại ' . $product['real_quantity'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="order_date_manufacture">Nhập số lượng</label><span
                                                    class="text-danger">*</span>
                                                <input type="text" value="{{ $productDetail->quantity }}"
                                                    class="form-control" name="order_quantity_{{ $countt }}"
                                                    placeholder="Nhập số lượng...">
                                            </div>


                                            <div class="form-group col-md-5">
                                                <label for="note_product_{{ $countt }}">Ghi chú</label>
                                                <textarea class="form-control" value="{{ $productDetail->note_product }}" id="note_product_1"
                                                    name="note_product_{{ $countt }}" rows="1">{{ old('note_product_' . $countt) }}</textarea>
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
                            @endif
                            @if (count($dataOldProduct) > 0)
                                    <?php $newIndex = 1; 
                                    $listProOld = getProductBasedWhHelper(old('order_wh'),old('customer_id'));
                                    ?>
                                    @foreach ($dataOldProduct as $index)
                                        <div class="form-row mr-0 ml-0 div-add-prod">
                                            <div class="form-group col-md-4">
                                                <label for="order_product_{{ $newIndex }}">Chọn Sản Phẩm</label><span class="text-danger">*</span>
                                                <select name="order_product_{{ $newIndex }}"
                                                    class="form-control select2">
                                                    @foreach ($listProOld as $keyP => $product)
                                                        <option value="{{ $keyP.'_'.$product['price'] }}"
                                                            {{ $keyP.'_'.$product['price'] == old('order_product_' . $index) ? 'selected' : '' }}>
                                                            {{ $product['name'].' - Giá '.$product['price'].' - Số lượng còn lại '.$product['real_quantity'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="order_date_manufacture">Nhập số lượng</label><span class="text-danger">*</span>
                                                <input type="text" value="{{ old('order_quantity_' . $index) }}"
                                                    class="form-control" name="order_quantity_{{ $newIndex }}"
                                                    placeholder="Nhập số lượng...">
                                            </div>

                                            
                                            <div class="form-group col-md-5">
                                                <label for="note_product_{{ $newIndex }}">Ghi chú</label>
                                                <textarea class="form-control" value="{{ old('note_product_' . $index) }}" id="note_product_1" name="note_product_{{ $newIndex }}" rows="1">{{ old('note_product_' . $index) }}</textarea>
                                            </div>
                                            @if($newIndex > 1)
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
                                            @endif
                                        </div>
                                        <?php $newIndex++; ?>
                                    @endforeach

                                @endif
                        </div>
                        <div class="form-group col-md-3">
                            <button type="button" id="addProduct" class="btn btn-secondary">Thêm Sản
                                Phẩm</button>
                        </div>
                    </div>
                </div>

                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" class="btn btn-warning"
                        onclick="window.location='{{ route('order.show', $order->id) }}'">Quay lại</button>
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
                var whId = $('#input_order_wh').find(":selected").val();
                var cusId = $('#customer_id').find(":selected").val();
                callProduct(whId, cusId);
            });
            $('#input_order_wh').on('change', '', function(e) {
                listProduct = '';
                $('.div-add-prod').remove();
                callProduct($(this).val(), $('#customer_id').find(":selected").val());
            });

            $('#customer_id').on('change', '', function(e) {
                listProduct = '';
                $('.div-add-prod').remove();
                callProduct($('#input_order_wh').find(":selected").val(), $(this).val());
            });
            function callProduct(whId, cusId) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('order.get.product') }}",
                    data: {
                        'wh_id': whId,
                        'cus_id': cusId
                    },
                    cache: false,
                    success: function(data) {
                        if (data.status_respone == true) {
                            if (data.list_product) {
                                listProduct = data.list_product
                            }
                            var options;
                            console.log(data);
                            $.each(data.list_product, function(prodId, value) {
                                options = options + '<option value="' + prodId + "_" + value
                                    .price + '">' + value
                                    .name + ' - Giá ' + value.price + ' - Số lượng còn lại ' +
                                    value.real_quantity +
                                    '</option>';
                            });
                            var numItems = $('.div-add-prod').length
                            var newNumItems = numItems + 1;
                            if (options != undefined) {
                                var structure = '<div class="form-row mr-0 ml-0 div-add-prod">' +
                                    '<div class="form-group col-md-4">' +
                                    '<label for="inputState">Chọn Sản Phẩm</label><span class="text-danger">*</span>' +
                                    '<select name="order_product_' + newNumItems + '" class="form-control select2">' +
                                    options;
                                var dele = '<div class="form-group col-md-1 a /nblign-self-center d-flex justify-content-center mb-0 div-product">' +
                                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash delete-product" viewBox="0 0 16 16">' +
                                    '<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />' +
                                    '<path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />' +
                                    '</svg>' +
                                    '</div>';
                                if($('.div-add-prod').length == 0){
                                    dele = '';
                                }
                                structure += '</select>' +
                                    '</div>' +
                                    '<div class="form-group col-md-2">' +
                                    '<label for="order_date_manufacture">Nhập số lượng</label><span class="text-danger">*</span>' +
                                    '<input type="text" class="form-control" name="order_quantity_' + newNumItems +
                                    '" placeholder="Nhập số lượng...">' +
                                    '</div>' +
                                    '<div class="form-group col-md-5">' +
                                    '<label for="note_product_' + newNumItems + '">Ghi chú</label>' +
                                    '<textarea class="form-control" id="nnote_product_' + newNumItems +
                                    '" name="note_product_' + newNumItems + '" rows="1">' +
                                    '</textarea>' +
                                    '</div>' +
                                    dele + 
                                    '</div>';
                                $("#containerProduct").append(structure);

                            }


                        }
                    }
                });
            }
            $('#containerProduct').on('click', '.delete-product', function() {
                $(this).parent().parent().remove();
            });
        });
    </script>
</x-layouts.main>
