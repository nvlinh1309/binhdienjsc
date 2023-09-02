<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Đơn mua</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('order-buyer.index') }}">Danh sách</a></li>
                            <li class="breadcrumb-item active">Đơn mua</li>
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
        {{-- <div class="card"> --}}

        <div class="callout callout-info">
            <div class="pl-0">
                {{-- <h3 class="card-title"> --}}
                <a style="text-decoration: none;" href="{{ route('order-buyer.purchase-order-export', $data->id) }}">
                    <button class=" btn btn-sm btn-primary">Xuất đơn đặt hàng</button>
                </a>
                {{-- <a style="text-decoration: none;" href="{{ route('instock.invoice', $data->id) }}">
                        <button class=" btn btn-sm btn-info" title="Tạo đơn hàng">Xuất đơn đặt hàng</button>
                    </a> --}}
                {{-- </h3> --}}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                    <h5><i class="fas fa-info"></i> Thông tin</h5>
                </div>
                <div class="col-md-6">
                    <b>Mã đơn hàng:</b> {{ $data->code }}
                </div>
                <div class="col-md-6">
                    <b>Assignee:</b> {{ $data->user_assignee->name }}
                </div>
                <div class="col-md-6">
                    <b>Nhà cung cấp:</b> <a target="_blank"
                        href="{{ route('supplier.show', $data->supplier->id) }}">{{ $data->supplier->name }}</a>
                </div>
                <div class="col-md-6">
                    <b>Kho:</b> <a target="_blank"
                        href="{{ route('store.show', $data->storage->id) }}">{{ $data->storage->name }}</a>
                </div>
                <div class="col-md-6">
                    <b>Ngày tạo đơn:</b> {{ $order_info->receipt_date }}
                </div>
                <div class="col-md-6">
                    <b>Người duyệt đơn đặt hàng: </b> {{ $data->user_order_approver->name }}
                </div>

                <div class="col-md-12">
                    <hr>
                    <h5><i class="fas fa-cube"></i> Sản phẩm</h5>
                    {{-- Thêm sản phẩm --}}
                    <form id="addProduct" method="POST" action="{{ route('order-buyer.add-product', $data->id) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="product_id">Chọn sản phẩm<span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="product_id" style="width: 100%;">
                                        @foreach ($products as $value)
                                            <option value="{{ $value->id }}">
                                                {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="quantity">Số lượng<span class="text-danger">*</span></label>
                                    <input value="" type="text" name="quantity" class="form-control" id="quantity"
                                        placeholder="Nhập số lượng...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="mfd">Ngày sản xuất<span class="text-danger">*</span></label>
                                    <input value="" type="text" class="form-control datepicker" name="mfd"
                                        id="mfd" data-provide="datepicker" placeholder="dd-mm-yyyy">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exp">Hạn sử dụng<span class="text-danger">*</span></label>
                                    <input value="" type="text" class="form-control datepicker" name="exp"
                                        id="exp" data-provide="datepicker" placeholder="dd-mm-yyyy">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="note">Ghi chú<span class="text-danger">*</span></label>
                                    <input value="" type="text" name="note" class="form-control" id="note"
                                        placeholder="Nhập ghi chú...">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div style="margin-top: 32px">
                                    <button class="btn btn-success">Thêm</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- Kết thúc thêm sản phẩm --}}
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tên SP</th>
                                <th>Số lượng</th>
                                <th>NSX</th>
                                <th>HSD</th>
                                <th>Ghi chú</th>
                                <th>Xoá</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @if ($product_info != null) --}}
                                @foreach ($product_info as $product)
                                    <tr>
                                        <td scope="row">{{ $product['name'] }}</td>
                                        <td>{{ number_format($product['quantity'], 0, ',', '.') }}</td>
                                        <td>{{ $product['mfd'] }}</td>
                                        <td>{{ $product['exp'] }}</td>
                                        <td>{{ $product['note'] }}</td>
                                        <td><a href="{{ route('order-buyer.delete-product', [$product['product_id'], $data->id]) }}">Xoá</a></td>
                                    </tr>
                                @endforeach
                            {{-- @endif --}}

                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Quay lại</button> --}}
            {{-- <button @if ($data->receipt_status === 4) disabled @endif class="btn btn-warning"
                onclick="window.location='{{ route('order-buyer.edit', $data->id) }}'">Chỉnh sửa</button> --}}
        </div>
        <!-- /.card-header -->

        <!-- /.card-body -->
    </div>
    </div>

    <script>
        $(function() {
            if ($("#addProduct").length > 0) {
                $('#addProduct').validate({
                    rules: {
                        quantity: {
                            required: true,
                            number: true
                        },
                        mfd: {
                            required: true,
                        },
                        exp: {
                            required: true,
                            greaterThan: "#mfd"
                        },
                        product_id: {
                            required: true,
                        }


                    },
                    messages: {
                        quantity: {
                            required: "Vui lòng nhập số lượng",
                            number: "Vui lòng nhập định dạng số"
                        },
                        mfd: {
                            required: "Vui lòng chọn NXS"
                        },
                        exp: {
                            required: "Vui lòng chọn HSD",
                            greaterThan: "Hạn sử dụng chưa hợp lệ"
                        },
                        product_id: {
                            required: "Sản phẩm chưa được chọn",
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

        jQuery(document).on('focus', ".datepicker", function() {
            jQuery(this).datepicker({
                format: 'dd-mm-yyyy'
            });
        });


    </script>
</x-layouts.main>
