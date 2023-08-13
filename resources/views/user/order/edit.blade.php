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
                                <select class="form-control select2" name="customer_id" style="width: 100%;"
                                    id="customer_id">
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
                                <select class="form-control select2" name="order_wh" style="width: 100%;">
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
                                {{-- value="{{ old('receipt_date') ? old('receipt_date') : ($order->receipt_date ? $order->receipt_date->format('d-m-Y') : '') }}" --}} name="receipt_date" id="" data-provide="datepicker">
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

                            @if (count($order->order_detail) > 0)
                                @foreach ($order->order_detail as $key => $productDetail)




                                @endforeach
                            @endif
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
    </script>
</x-layouts.main>
