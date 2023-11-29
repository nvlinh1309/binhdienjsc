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
                            <li class="breadcrumb-item"><a href="{{ route('order-buyer.index') }}">Danh sách</a></li>
                            <li class="breadcrumb-item active">{{ $order->code }}</li>
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
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Đơn hàng: {{ $order->code }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div><b>Mã đơn hàng:</b> {{ $order->code }}</div>
                        <div><b>Người kiểm duyệt:</b> {{ $order->approvedBy->name }}</div>
                        <div><b>Tên NCC:</b> {{ $order->supplier->name }}</div>
                        <div><b>Địa chỉ NCC:</b> {{ $order->supplier->address }}</div>
                    </div>
                    <div class="col-md-6">
                        <div><b>Thông tin đơn vị mua hàng:</b> {{ $order->company_name }}</div>
                        <div>Địa chỉ: {{ $order->company_address }}</div>
                        <div>Mã số thuế: {{ $order->company_tax }}</div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <div><b>Thời gian dự kiến giao hàng:</b> {{ $order->estimated_delivery_time }}</div>
                    </div>
                    <div class="col-md-6">
                        <div><b>Kho nhận hàng:</b> {{ $order->storage->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <hr>
                        <b>Trạng thái đơn hàng:</b> <i
                            class="badge {{ $statusColor[$order->status] }}">{{ $order->status ? $statusList[$order->status] : '' }}</i>
                        @if ($order->status > 4 && $order->created_by == auth()->user()->id)
                            <a href="{{ route('order-buyer.export-order', $order->id) }}"
                                class="btn btn-sm btn-outline-success"> <i class="fa fa-save"></i> Xuất ĐĐH</a>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <hr>
                        <div><b>File ĐĐH:</b> <i>
                            @if ($order->order_file)
                            <a target="_blank" href="{{ asset('uploads/'.$order->order_file) }}">{{$order->order_file}}</a>
                            @else
                                Chưa có dữ liệu...
                            @endif
                            </i></div>
                        <div><b>File PNK:</b> <i>
                            @if ($order->order_file)
                            <a target="_blank" href="{{ asset('uploads/'.$order->order_file) }}">{{$order->order_file}}</a>
                            @else
                                Chưa có dữ liệu...
                            @endif
                        </i></div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <h5><i class="nav-icon fas fa-archive"></i>Sản phẩm</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mặt hàng</th>
                                    <th>Quy cách bao bì</th>
                                    <th>Số lượng (kg)</th>
                                    <th>Đơn giá (vnd/kg)</th>
                                    <th>Thành tiền (vnđ)</th>
                                    <th>Chi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_quantity = 0;
                                $total_price = 0;
                                $total_price = 0;
                                ?>
                                @foreach ($order->products as $index => $item)
                                    <tr>
                                        <td scope="row">{{ $index + 1 }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->product->specification . '(' . $item->product->unit . ')' }}</td>
                                        <td>{{ number_format($item->product_quantity, 0, ',', '.') }}</td>
                                        <td>{{ number_format($item->product_price, 0, ',', '.') }}</td>
                                        <td>{{ number_format($item->product_quantity * $item->product_price, 0, ',', '.') }}
                                        </td>
                                        <td>{{ $item->product_note }}</td>
                                    </tr>
                                    <?php
                                    $total_quantity += $item->product_quantity;
                                    $total_price += $item->product_quantity * $item->product_price;
                                    ?>
                                @endforeach

                                <tr style='background-color:beige'>
                                    <td scope="row" colspan=3" class="text-right"><b>Tổng cộng:</b></td>
                                    <td>{{ number_format($total_quantity, 0, ',', '.') }}</td>
                                    <td></td>
                                    <td>{{ number_format($total_price, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                @if (in_array($order->status, [3, 2]) && $order->created_by == auth()->user()->id)
                    <a href="{{ route('order-buyer.step2', $order->id) }}" class="btn btn-secondary">Quay lại</a>
                    <a href="{{ route('order-buyer.step4', $order->id) }}" class="btn btn-primary"
                        onclick="return confirm_send()">Gửi đơn chờ duyệt</a>
                @endif

                @if ($order->approved_by == auth()->user()->id && $order->status == 4)
                    <a href="{{ route('order-buyer.reject', $order->id) }}" class="btn btn-danger">Từ chối</a>
                    <a href="{{ route('order-buyer.approve', $order->id) }}" class="btn btn-primary"
                        onclick="return confirm_approved()">Duyệt</a>
                @endif

                @if ($order->created_by == auth()->user()->id && $order->status == 5 && $order->order_file == null)
                    <form id="quickForm" action="{{ route('order-buyer.order-upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" name="order_file" class="custom-file-input" id="order_file">
                                    <label class="custom-file-label" for="order_file"><i>Tải lên file ĐĐH đã được trình
                                            ký (Định dạng PDF)...</i></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Lưu và tiếp tục tạo PNK</button>
                            </div>
                        </div>
                    </form>
                @endif

                @if ($order->created_by == auth()->user()->id && $order->order_file != null)
                    <a href="{{ route('order-buyer.step6', $order->id) }}" class="btn btn-primary">Tạo phiếu nhập kho</a>
                @endif


            </div>
        </div>
    </div>

    <script>
        function confirm_send() {
            return confirm('Vui lòng kiểm tra kỹ thông tin trước khi gửi xác nhận đơn hàng.');
        }

        function confirm_approved() {
            return confirm('Vui lòng kiểm tra kỹ thông tin trước khi gửi xác nhận duyệt đơn đặt hàng.');
        }

        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        $(function() {
            if ($("#quickForm").length > 0) {
                $('#quickForm').validate({
                    rules: {
                        order_file: {
                            required: true,
                            extension: "pdf"
                        }
                    },
                    messages: {
                        order_file: {
                            required: "Vui lòng nhập số lượng sản phẩm",
                            extension: "Không đúng định dạng file pdf"
                        }
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.custom-file').append(error);
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
