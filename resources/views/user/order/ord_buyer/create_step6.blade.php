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
                            <li class="breadcrumb-item active">Tạo phiếu nhập kho</li>
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
                <h3 class="card-title">ĐĐH: {{ $order->code }}</h3>
            </div>

            <form id="quickForm" action="{{ route('order-buyer.update.step6', $order->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="spn_number">SPN: <span class="text-danger">*</span></label>
                                <input value="" type="text" name="spn_number" class="form-control"
                                    id="spn_number" placeholder="Nhập SPN...">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="code">Mã nhập kho: <span class="text-danger">*</span></label>
                                <input value="" type="text" name="code" class="form-control" id="code"
                                    placeholder="Mã nhập kho...">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="input_date">Ngày nhập kho: <span class="text-danger">*</span></label>
                                <input value="" type="date" name="input_date" class="form-control"
                                    id="input_date" placeholder="Ngày nhập kho...">
                            </div>
                        </div>


                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="warehouse_staff_id">Chọn thủ kho: <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="warehouse_staff_id" id="warehouse_staff_id"
                                    style="width: 100%;">
                                    @foreach ($warehouse_keeper as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == old('warehouse_staff_id') ? 'selected' : '' }}>
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="content">Thông tin giao nhận:</label>
                                <input value="" type="text" name="content" class="form-control" id="content"
                                    placeholder="Thông tin giao nhận...">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cont">Xe/Cont:</label>
                                <input value="" type="text" name="cont" class="form-control" id="cont"
                                    placeholder="Ngày Xe/Cont...">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <h5><i class="nav-icon fas fa-archive"></i>Sản phẩm</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm hàng hoá</th>
                                        <th>Quy cách đóng gói/kg</th>
                                        <th>Đơn vị tính</th>
                                        <th>Khối lượng (kg)</th>
                                        <th>Ngày sản xuất <span class="text-danger">*</span></th>
                                        <th>Hạn sử dụng <span class="text-danger">*</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->products as $item)
                                        <tr>
                                            <td scope="row"> {{ $item->product->name }}</td>
                                            <td>{{ $item->product->specification }}</td>
                                            <td>{{ $item->product->unit }}</td>
                                            <td>{{ $item->product_quantity }}</td>
                                            <td>
                                                <div class="form-group">
                                                    <input value="" type="date"
                                                        name="product_exp_{{ $item->id }}" class="form-control"
                                                        id="product_exp_{{ $item->id }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input value="" type="date"
                                                        name="product_mfg_{{ $item->id }}" class="form-control"
                                                        id="product_mfg_{{ $item->id }}">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('order-buyer.step3', $order->id) }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu và tiếp tục</button>
                </div>

            </form>
        </div>
        <!-- /.card -->
    </div>


    <script>
        $(function() {
                    if ($("#quickForm").length > 0) {
                        $('#quickForm').validate({
                                rules: {
                                    code: {
                                        required: true,
                                    },
                                    spn_number: {
                                        required: true
                                    },
                                    input_date: {
                                        required: true
                                    },
                                    warehouse_staff_id: {
                                        required: true
                                    },
                                    product_exp: {
                                        required: true
                                    },
                                    @foreach ($order->products as $item)
                                        "product_mfg_{{ $item->id }}": {
                                            required: true,
                                        },
                                        "product_exp_{{ $item->id }}": {
                                            required: true,
                                        },
                                    @endforeach
                                },
                                messages: {
                                    code: {
                                        required: "Vui lòng nhập mã nhập kho",
                                    },
                                    spn_number: {
                                        required: "Vui lòng nhập SPN"
                                    },
                                    input_date: {
                                        required: "Vui lòng chọn ngày nhập kho hợp lệ"
                                    },
                                    warehouse_staff_id: {
                                        required: "Vui lòng chọn thủ kho"
                                    },
                                    @foreach ($order->products as $item)
                                            "product_mfg_{{ $item->id }}": {
                                                required: "Vui lòng chọn ngày sản xuất hợp lệ",
                                            },
                                            "product_exp_{{ $item->id }}": {
                                                required: "Vui lòng chọn hạn sử dụng hợp lệ",
                                            },
                                    @endforeach
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
