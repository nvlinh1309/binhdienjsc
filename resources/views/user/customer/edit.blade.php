<x-layouts.main>
    <div class="col-md-12">
        @if (\Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i>Thành công!</h5>
                {!! \Session::get('success') !!}
            </div>
        @endif
    </div>
    <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cập nhật thông tin khách hàng <strong>{{ $data->name }}</strong></h3>
            </div>

            <form id="update" action="{{ route('customer.update', $data->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="code">Mã khách hàng</label>
                                <input type="text" name="code" value="{{ $data->code }}" class="form-control"
                                    id="code" placeholder="Nhập mã khách hàng...">
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Tên khách hàng</label>
                                <input type="text" name="name" value="{{ $data->name }}" class="form-control"
                                    id="name" placeholder="Nhập tên khách hàng...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tax_code">Mã số thuế</label>
                                <input type="text" name="tax_code" value="{{ $data->tax_code }}" class="form-control"
                                    id="tax_code" placeholder="Nhập mã số thuế...">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tax">Thuế suất</label>
                                <input type="number" min="0" max="100" value="{{ $data->tax }}"
                                    name="tax" class="form-control" id="tax" placeholder="Nhập thuế suất...">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input type="text" name="address" value="{{ $data->address }}" class="form-control"
                                    id="address" placeholder="Nhập địa chỉ...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="contact[email]" value="{{ $data->contact['email'] }}"
                                    class="form-control" id="email" placeholder="Nhập email...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="phone">Điện thoại</label>
                                <input type="text" name="contact[phone]" value="{{ $data->contact['phone'] }}""
                                    class="form-control" id="phone" placeholder="Nhập số điện thoại...">
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('customer.index') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

</x-layouts.main>
