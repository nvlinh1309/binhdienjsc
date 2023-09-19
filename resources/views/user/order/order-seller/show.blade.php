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
                            <li class="breadcrumb-item"><a href="{{ route('order-seller.index') }}">Danh sách</a></li>
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
                    <a style="text-decoration: none;"
                        href="{{ route('order-seller.to-deliver-export', $data->id) }}">
                        <button class=" btn btn-sm btn-primary">Phiếu xuất kho</button>
                    </a>
                    <a style="text-decoration: none;"
                        href="{{ route('order-seller.invoice-request-form', $data->id) }}">
                        <button class=" btn btn-sm btn-info">Giấy đề nghị xuất hoá đơn</button>
                    </a>
                @if ($data->status < 3 && $data->assignee === auth()->user()->id)
                    <a style="text-decoration: none;" href="{{ route('order-seller.update-status', [$data->id, 3]) }}">
                        <button class=" btn btn-sm btn-primary">Hoàn tất và gửi yêu cầu duyệt đơn đặt hàng</button>
                    </a>
                @elseif ($data->status === 3 && $data->assignee === auth()->user()->id)
                    <a style="text-decoration: none;" href="{{ route('order-seller.update-status', [$data->id, 4]) }}">
                        <button class=" btn btn-sm btn-success">Duyệt đơn đặt hàng</button>
                    </a>
                    <a style="text-decoration: none;" href="{{ route('order-seller.update-status', [$data->id, 2]) }}">
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
                    <b>Mã đơn hàng:</b> {{ $data->to_deliver_code }}
                </div>
                <div class="col-md-6">
                    <b>Người tạo đơn:</b> {{ $data->createdBy->name }}
                </div>
                <div class="col-md-6">
                    <b>Nhà khách hàng:</b> <a target="_blank"
                        href="{{ route('customer.edit', $data->customer->id) }}">{{ $data->customer->name }}</a>
                </div>

                <div class="col-md-6">
                    <b>Người duyệt đơn đặt hàng: </b> {{ $data->user_order_approver->name }}
                </div>
                <div class="col-md-6">
                    <b>Ngày xuất kho: </b> {{ $data->to_deliver_date }}
                </div>
                <div class="col-md-6">
                    <b>Nhân viên kho vận: </b> {{ $data->warehouseKeeper->name }}
                </div>
                <div class="col-md-6">
                    <b>Kho xuất hàng: </b> {{ $data->storage->name }}
                </div>
                <div class="col-md-6">
                    <b>Trạng thái: </b><i class="badge {{ $statusColor[$data->status] }}">{{ $data->status ? $statusList[$data->status] : '' }}</i>
                </div>
                <div class="col-md-12 text-right">
                    @if ($data->status < 3 && $data->assignee === auth()->user()->id)
                        <form method="POST" action="{{ route('order-seller.destroy', $data->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class=" btn btn-sm btn-secondary cancel">Huỷ đơn hàng</button>
                        </form>
                    @endif

                </div>


                <div class="col-md-12">
                    <hr>
                    <h5><i class="fas fa-cube"></i> Sản phẩm</h5>
                    {{-- Thêm sản phẩm --}}
                    @if ($data->status < 3 && $data->assignee === auth()->user()->id)
                        <form id="addProduct" method="POST"
                            action="{{ route('order-seller.add-product', $data->id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="product_id">Chọn sản phẩm<span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="product_id" style="width: 100%;" id="product_id">
                                            @foreach ($products as $value)
                                                <option value="{{ $value->product->id }}">
                                                    {{ $value->product->name }} ({{ $value->product->specification.strtoupper($value->product->unit) }}) ({{$value->in_stock}} SP)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="quantity">Số lượng (Kg)<span class="text-danger">*</span></label>
                                        <input value="" type="text" name="quantity" class="form-control"
                                            id="quantity" placeholder="Nhập số lượng...">
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
                                <th>Giá</th>
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
                                    <td>{{ number_format($product['price'], 0, ',', '.') }} (VNĐ)</td>
                                    <td>{{ $product['note'] }}</td>
                                    @if ($data->status < 3)
                                        <td><a
                                                href="{{ route('order-seller.delete-product', [$product['product_id'], $data->id]) }}">Xoá</a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($data->status == 4 && $data->assignee === auth()->user()->id)
                        <div class="text-right">
                            <a style="text-decoration: none;" href="{{ route('order-seller.update-status', [$data->id, 5]) }}">
                                <button class=" btn btn-sm btn-success">Xác nhận đã xuất kho</button>
                            </a>
                        </div>
                    @endif

                    @if ($data->status == 5 && $data->assignee === auth()->user()->id)
                        <div class="text-right">
                            <a style="text-decoration: none;" href="{{ route('order-seller.update-status', [$data->id, 6]) }}">
                                <button class=" btn btn-sm btn-warning">Xác nhận đã thanh toán</button>
                            </a>
                        </div>
                    @endif
                </div>







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
                        product_id: {
                            required: true,
                        }


                    },
                    messages: {
                        quantity: {
                            required: "Vui lòng nhập số lượng",
                            number: "Vui lòng nhập định dạng số"
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
