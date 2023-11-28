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
                            <li class="breadcrumb-item active">Đơn hàng: {{ $order->code }}</li>
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
                <h3 class="card-title">Đơn hàng: {{ $order->code }}</h3>
            </div>

            <div class="card-body">

                <form id="quickForm" action="{{ route('order-buyer.add-product', $order->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="product_id">Chọn sản phẩm: <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="product_id" id="product_id"
                                    style="width: 100%;">
                                    @foreach ($products as $value)
                                        <option value="{{ $value->id }}"
                                            {{ $value->id == old('product_id') ? 'selected' : '' }}>
                                            {{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="product_price">Giá mua (VNĐ): <span class="text-danger">*</span></label>
                                <input value="" type="text" name="product_price" class="form-control"
                                    id="product_price" placeholder="Nhập giá mua...">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="product_quantity">Số lượng: <span class="text-danger">*</span></label>
                                <input value="" type="text" name="product_quantity" class="form-control"
                                    id="product_quantity" placeholder="Nhập số lượng...">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="product_note">Ghi chú:</label>
                                <input value="" type="text" name="product_note" class="form-control"
                                    id="product_note" placeholder="Nhập ghi chú...">
                            </div>
                        </div>

                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-outline-success">Thêm</button>
                        </div>
                    </div>
                </form>

                <hr>
                <h5>DANH SÁCH SẢN PHẨM</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mặt hàng</th>
                            <th>Quy cách bao bì</th>
                            <th>Số lượng (kg)</th>
                            <th>Đơn giá (vnđ/kg)</th>
                            <th>Thành tiền (vnđ)</th>
                            <th>Ghi chú</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $index => $value)
                            <tr>
                                <td scope="row">{{ $index + 1 }}</td>
                                <td>{{ $value->product->name }}</td>
                                <td>{{ $value->product->specification . $value->product->unit }}</td>
                                <td>{{ number_format($value->product_quantity, 0, ',', '.') }}</td>
                                <td>{{ number_format($value->product_price, 0, ',', '.') }}</td>
                                <td>{{ number_format($value->product_price * $value->product_quantity, 0, ',', '.') }}</td>
                                <td>{{ $value->product_note }}</td>
                                <td><a href="">Xoá</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{ route('order-buyer.step1', $order->id) }}" class="btn btn-secondary">Quay lại</a>
                <a href="{{ route('order-buyer.update.step2', $order->id) }}" class="btn btn-primary">Tiếp tục</a>
            </div>
        </div>
        <!-- /.card -->
    </div>


    <script>
        $(function() {
            if ($("#quickForm").length > 0) {
                $('#quickForm').validate({
                    rules: {
                        product_quantity: {
                            required: true,
                            digits: true
                        },
                        product_price: {
                            required: true,
                            digits: true
                        }
                    },
                    messages: {
                        product_quantity: {
                            required: "Vui lòng nhập số lượng sản phẩm",
                            digits: "Số lượng chưa đúng định dạng"
                        },
                        product_price: {
                            required: "Vui lòng nhập giá mua",
                            digits: "Giá sản phẩm chưa đúng định dạng"
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
</x-layouts.main>
