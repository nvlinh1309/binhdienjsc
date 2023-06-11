<x-layouts.main>
    <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thêm sản phẩm mới</h3>
            </div>

            <form id="quickForm" action="{{ route('product.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="barcode">Barcode</label>
                                <input type="text" name="barcode" class="form-control" id="barcode"
                                    placeholder="Nhập barcode...">
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Nhập tên sản phẩm...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="brand_name">Thương hiệu</label>
                                <input type="text" name="brand_name" class="form-control" id="brand_name"
                                    placeholder="Nhập thương hiệu...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="specification">Quy cách</label>
                                <input type="text" name="specification" class="form-control" id="specification"
                                    placeholder="Nhập địa chỉ...">
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
