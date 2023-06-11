<x-layouts.main>
    <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Khởi tạo đơn hàng</h3>
            </div>

            <form id="quickForm" action="{{ route('order.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_code">Mã đơn hàng</label>
                                <input type="text" name="order_code" class="form-control" id="order_code"
                                    placeholder="Nhập mã đơn hàng...">
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Chọn khách hàng</label>
                                <select class="form-control select2" style="width: 100%;">
                                    {{-- <option selected="selected">Alabama</option> --}}
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <h5>Sản phẩm</h5>
                            <hr>

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

</x-layouts.main>
