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
                            <li class="breadcrumb-item"><a href="{{ route('order-seller.index') }}">Đơn mua (Nhập kho)</a>
                            </li>
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

            <form id="quickForm" action="{{ route('order-seller.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <input value="{{ auth()->user()->id }}" type="hidden" name="assignee">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="to_deliver_code">Mã phiếu xuất kho<span class="text-danger">*</span></label>
                                <input value="{{ old('to_deliver_code') }}" type="text" name="to_deliver_code"
                                    class="form-control" id="to_deliver_code" placeholder="Nhập mã phiếu xuất kho...">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="to_deliver_date">Ngày xuất kho<span class="text-danger">*</span></label>
                                <input value="{{ old('to_deliver_date', now()->format('d-m-Y')) }}" type="text"
                                    class="form-control datepicker" name="to_deliver_date" id="to_deliver_date"
                                    data-provide="datepicker" placeholder="dd-mm-yyyy">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="storage_id">Chọn kho<span class="text-danger">*</span></label>
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

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="customer_id">Chọn khách hàng<span class="text-danger">*</span></label>
                                <select class="form-control select2" name="customer_id" id="customer_id"
                                    style="width: 100%;">
                                    @foreach ($customers as $customers)
                                        <option value="{{ $customers->id }}"
                                            {{ $customers->id == old('customer_id') ? 'selected' : '' }}>
                                            {{ $customers->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="to_deliver_info">Thông tin giao nhận</label>
                                <input value="{{ old('to_deliver_info') }}" type="text" name="to_deliver_info"
                                    class="form-control" id="to_deliver_info" placeholder="Nhập thông tin giao nhận...">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="to_deliver_transport">Xe/Cont</label>
                                <input value="{{ old('to_deliver_transport') }}" type="text"
                                    name="to_deliver_transport" class="form-control" id="to_deliver_transport"
                                    placeholder="Nhập xe/cont...">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Chọn Thủ kho<span class="text-danger">*</span></label>
                                <select class="form-control select2" name="warehouse_keeper" id="warehouse_keeper"
                                    style="width: 100%;">
                                    @foreach ($users as $user)
                                    @if ($user->roles[0]->name === 'warehouse_keeper')
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == old('warehouse_keeper') ? 'selected' : '' }}>
                                            {{ $user->name }}</option>
                                            @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Người duyệt đơn đặt hàng<span class="text-danger">*</span></label>
                                <select class="form-control select2" name="order_approver" id="order_approver"
                                    style="width: 100%;">
                                    @foreach ($users as $user)
                                        @if ($user->roles[0]->name === 'manager')
                                            <option value="{{ $user->id }}"
                                                {{ $user->id == old('order_approver') ? 'selected' : '' }}>
                                                {{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
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
        $(function() {
            $("#add_product").click(function() {
                alert(1);
            })
            if ($("#quickForm").length > 0) {
                $('#quickForm').validate({
                    rules: {
                        to_deliver_code: {
                            required: true,
                        },
                        to_deliver_date: {
                            required: true
                        },
                        customer_id: {
                            required: true
                        },
                        warehouse_keeper: {
                            required: true
                        },
                        order_approver: {
                            required: true
                        }
                    },
                    messages: {
                        to_deliver_code: {
                            required: "Vui lòng nhập mã phiếu xuất kho"
                        },
                        to_deliver_date: {
                            required: "Vui lòng chọn ngày xuất kho",
                        },
                        customer_id: {
                            required: "Vui lòng chọn khách hàng",
                        },
                        warehouse_keeper: {
                            required: "Vui lòng chọn thủ kho",
                        },
                        order_approver: {
                            required: "Vui lòng chọn người duyệt đơn hàng",
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
