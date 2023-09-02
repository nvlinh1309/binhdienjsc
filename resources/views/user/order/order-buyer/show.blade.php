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

        <div class="callout callout-info">
            <div class="pl-0">
                @if ($data->status >= 3)
                    <a style="text-decoration: none;"
                        href="{{ route('order-buyer.purchase-order-export', $data->id) }}">
                        <button class=" btn btn-sm btn-primary">Xuất đơn đặt hàng</button>
                    </a>
                @endif
                @if ($data->status > 4)
                    <a style="text-decoration: none;"
                        href="{{ route('order-buyer.warehouse-recript-export', $data->id) }}">
                        <button class=" btn btn-sm btn-info">Xuất phiếu nhập kho</button>
                    </a>
                @endif
                @if ($data->status < 3 && $data->assignee === auth()->user()->id)
                    <a style="text-decoration: none;" href="{{ route('order-buyer.update-status', [$data->id, 3]) }}">
                        <button class=" btn btn-sm btn-primary">Hoàn tất và gửi yêu cầu duyệt đơn đặt hàng</button>
                    </a>
                @elseif ($data->status === 3 && $data->assignee === auth()->user()->id)
                    <a style="text-decoration: none;" href="{{ route('order-buyer.update-status', [$data->id, 4]) }}">
                        <button class=" btn btn-sm btn-success">Duyệt đơn đặt hàng</button>
                    </a>
                    <a style="text-decoration: none;" href="{{ route('order-buyer.update-status', [$data->id, 2]) }}">
                        <button class=" btn btn-sm btn-secondary">Từ chối</button>
                    </a>
                @endif


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
                    <b>Người tạo đơn:</b> {{ $data->createdBy->name }}
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
                <div class="col-md-6">
                    <b>Trạng thái: </b> <i>{{ $data->status ? $statusList[$data->status] : '' }}</i>
                </div>
                <div class="col-md-12 text-right">
                    @if ($data->status < 3 && $data->assignee === auth()->user()->id)
                        <form method="POST" action="{{ route('order-buyer.destroy', $data->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class=" btn btn-sm btn-secondary cancel">Huỷ đơn hàng</button>
                        </form>
                    @endif

                </div>
                @if ($data->status < 3 && $data->assignee === auth()->user()->id)
                <div class="col-md-12">
                    <hr>
                    <h5><i class="fas fa-cube"></i> Sản phẩm</h5>
                    {{-- Thêm sản phẩm --}}
                    @if ($data->status < 3)
                        <form id="addProduct" method="POST"
                            action="{{ route('order-buyer.add-product', $data->id) }}">
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
                                        <input value="" type="text" name="quantity" class="form-control"
                                            id="quantity" placeholder="Nhập số lượng...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="mfd">Ngày sản xuất<span class="text-danger">*</span></label>
                                        <input value="" type="text" class="form-control datepicker"
                                            name="mfd" id="mfd" data-provide="datepicker"
                                            placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exp">Hạn sử dụng<span class="text-danger">*</span></label>
                                        <input value="" type="text" class="form-control datepicker"
                                            name="exp" id="exp" data-provide="datepicker"
                                            placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="note">Ghi chú</label>
                                        <input value="" type="text" name="note" class="form-control"
                                            id="note" placeholder="Nhập ghi chú...">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div style="margin-top: 32px">
                                        <button class="btn btn-success">Thêm</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                    {{-- Kết thúc thêm sản phẩm --}}
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tên SP</th>
                                <th>Số lượng</th>
                                <th>NSX-HSD</th>
                                <th>Giá đặt hàng</th>
                                <th>Ghi chú</th>
                                @if ($data->status < 3)
                                    <th>Xoá</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product_info as $product)
                                <tr>
                                    <td scope="row">
                                        <a target="_blank"
                                            href="{{ route('product.show', $product['product_id']) }}">{{ $product['name'] }}</a>
                                    </td>
                                    <td>{{ number_format($product['quantity'], 0, ',', '.') }}</td>
                                    <td>
                                        NSX: {{ $product['mfd'] }}<br>
                                        HSD: {{ $product['exp'] }}
                                    </td>
                                    <td>{{ number_format($product['price'], 0, ',', '.') }} (VNĐ)</td>
                                    <td>{{ $product['note'] }}</td>
                                    @if ($data->status < 3)
                                        <td><a
                                                href="{{ route('order-buyer.delete-product', [$product['product_id'], $data->id]) }}">Xoá</a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                @if ($data->status == 4 && $data->assignee === auth()->user()->id)
                    <div class="col-md-12">
                        <form id="addWarehouseRecript" method="POST" action="{{ route('order-buyer.add-warehouse_recript', $data->id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <h5><i class="fas fa-info"></i> Thông tin nhập kho</h5>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="code">Số nhập kho<span class="text-danger">*</span></label>
                                        <input value="{{ $warehouse_recript->code ?? '' }}" type="text" name="code" class="form-control"
                                            id="quacodentity" placeholder="Nhập Số nhập kho...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="date_input">Ngày nhập kho<span class="text-danger">*</span></label>
                                        <input value="{{ $warehouse_recript->date_input ?? '' }}" type="text" class="form-control datepicker"
                                            name="date_input" id="date_input" data-provide="datepicker"
                                            placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="info">Thông tin giao nhận</label>
                                        <input value="{{ $warehouse_recript->info ?? '' }}" type="text" name="info" class="form-control"
                                            id="info" placeholder="Nhập thông tin giao nhận...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="transport">Xe/Cont</label>
                                        <input value="{{ $warehouse_recript->info ?? '' }}" type="text" name="transport" class="form-control"
                                            id="transport" placeholder="Nhập xe/cont...">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div style="margin-top: 32px">
                                        <button class="btn btn-success">Gửi y/c duyệt phiếu nhập kho</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                @endif


                @if ($data->status > 4)
                    <div class="col-md-12">
                        <hr>
                        <h5><i class="fas fa-info"></i> Thông tin nhập kho</h5>
                    </div>
                    <div class="col-md-6">
                        <b>Số nhập kho:</b> {{ $warehouse_recript->code }}
                    </div>
                    <div class="col-md-6">
                        <b>Ngày nhập kho:</b> {{ $warehouse_recript->date_input }}
                    </div>
                    <div class="col-md-6">
                        <b>Thông tin giao nhận:</b> {{ $warehouse_recript->info??"N/A" }}
                    </div>
                    <div class="col-md-6">
                        <b>Xe/Cont:</b> {{ $data->transport??"N/A" }}
                    </div>
                    @if ($data->status == 5 && $data->assignee == auth()->user()->id)
                    <div class="col-md-12 text-right">
                        @if ($data->status)
                            <a href="{{ route('order-buyer.update-status', [$data->id, 6]) }}">
                                <button class=" btn btn-sm btn-primary">Phê duyệt</button>
                            </a>
                            <a href="{{ route('order-buyer.update-status', [$data->id, 4]) }}">
                                <button class=" btn btn-sm btn-secondary">Từ chối</button>
                            </a>
                        @endif

                    </div>
                    @endif
                    @if ($data->status == 6 && $data->assignee == auth()->user()->id)
                    <div class="col-md-12 text-right">
                        @if ($data->status)
                        <a href="{{ route('order-buyer.update-status', [$data->id, 7]) }}">
                            <button class=" btn btn-sm btn-success completebtn">Xác nhận đã nhập kho</button>
                        </a>
                        @endif

                    </div>
                    @endif
                @endif


            </div>
        </div>
    </div>
    </div>

    <script>
        $(function() {
            $(".completebtn").click(function(){
                $(this).prop('disabled', true);
            })

            if($("#addWarehouseRecript").length > 0) {
                $('#addWarehouseRecript').validate({
                    rules: {
                        code: {
                            required: true
                        },
                        date_input: {
                            required: true
                        }
                    },
                    messages: {
                        code: {
                            required: "Vui lòng không bỏ trống",
                        },
                        date_input: {
                            required: "Vui lòng không bỏ trống",
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
                        },
                        code: {
                            required: true
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
                        },
                        code: {
                            required: "Vui lòng không bỏ trống",
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

        $(document).ready(function() {
            $('.cancel').on('click', function(e) {
                var name = $(this).attr('data-id');
                e.preventDefault()
                if (confirm('Bạn có chắc chắn huỷ đơn hàng này?')) {
                    $(e.target).closest('form').submit()
                }
            });
        });
    </script>
</x-layouts.main>
