<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Nhà cung cấp</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Danh sách</a></li>
                            <li class="breadcrumb-item active">Thêm nhà cung cấp</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    @stop()
    <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thêm nhà cung cấp mới</h3>
            </div>

            <form id="quickForm" action="{{ route('supplier.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="supplier_code">Mã nhà cung cấp</label>
                                <input type="text" name="supplier_code" required class="form-control" id="supplier_code"
                                    placeholder="Nhập mã nhà cung cấp...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Tên công ty</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Nhập tên công ty...">
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input type="text" name="address" class="form-control" id="address"
                                    placeholder="Nhập địa chỉ...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tax_code">Mã số thuế</label>
                                <input type="text" name="tax_code" class="form-control" id="tax_code"
                                    placeholder="Nhập mã số thuế...">
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

</x-layouts.main>
