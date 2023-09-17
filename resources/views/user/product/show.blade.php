<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sản phẩm</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Sản phẩm</a></li>
                            <li class="breadcrumb-item active">{{ $data->name }}</li>
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
    <div class="col-md-12 float-right">
        <p class="mb-2 float-right"><a class="link-opacity-100" href="{{ route('product.history', $data->id) }}">Lịch
                sử</a></p>
    </div>
    <div class="col-md-12">
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Thông tin</h5>
            <div><b>Tên sản phẩm:</b> {{ $data->name }}</div>
            <div><b>Barcode:</b> {{ $data->barcode }}</div>
            <div><b>Thương hiệu:</b> {{ $data->brand->name }}</div>
            <div><b>Quy cách đóng gói:</b> {{ $data->specification }} ({{ $data->unit }})</div>
            <div><b>Giá sản phẩm (VNĐ):</b> {{ number_format($data->price) }}</div>
            <div><b>Ngày tạo:</b> {{ $data->created_at }}</div>
            <hr>
            <div><b>Tồn kho:</b> 0</div>
            <div><b>Đã bán:</b> 0</div>
            <hr>

            {{-- <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Quay lại</button> --}}
            @can('product-edit')
                <button class="btn btn-warning" onclick="window.location='{{ route('product.edit', $data->id) }}'">Chỉnh
                    sửa</button>
            @endcan
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Thông tin giá sản phẩm theo từng khách hàng.
                </h3>

                <div class="card-tools">
                    {{-- {{ $data->links('vendor.pagination.default') }} --}}
                </div>
            </div>
            <!-- /.card-header -->

            <div class="card-body p-0">
                <form id="setPriceForm" action="{{ route('product.price.store') }}" method="POST">
                    <input type="hidden" name="product_id" value="{{ $data->id }}" />
                    <table class="table">
                        @csrf
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Tên khách hàng</th>
                                <th>Giá (VNĐ)</th>
                            </tr>
                        </thead>
                        @if (count($data->price_customer) > 0)
                            <?php $num = 1; ?>
                            @foreach ($data->price_customer as $detail)
                                @if ($detail->customer)
                                    <tr>
                                        <td>{{ $num }}</td>
                                        <td>
                                            {{ $detail->customer->name }}
                                        </td>
                                        <td>
                                            <input type="text" name="price_{{ $detail->customer_id }}"
                                                class="form-control input-price" id=""
                                                value="{{ number_format($detail->price) }}"
                                                placeholder="Nhập giá đối với khách hàng...">
                                        </td>
                                    </tr>
                                    <?php $num++; ?>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">Chưa có dữ liệu</td>
                            </tr>
                        @endif
                        @can('product-edit')
                            <tr>
                                <td colspan="3"><button type="submit" class="btn btn-secondary">Cập nhật giá</button></td>

                            </tr>
                        @endcan
                    </table>

                </form>
            </div>


            <!-- /.card-body -->
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.input-price').on('input', function(e) {
                $(this).val(formatCurrency(this.value.replace(/[,$]/g, '')));
            }).on('keypress', function(e) {
                if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
            }).on('paste', function(e) {
                var cb = e.originalEvent.clipboardData || window.clipboardData;
                if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
            });

            function formatCurrency(number) {
                var n = number.split('').reverse().join("");
                var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");
                return n2.split('').reverse().join('');
            }
        });
    </script>
</x-layouts.main>
