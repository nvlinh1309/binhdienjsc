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
                            <li class="breadcrumb-item active">Tạo đơn hàng</li>
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
                <h3 class="card-title">Khởi tạo đơn hàng</h3>
            </div>

            <form id="quickForm" action="{{ route('stock-in.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_code">Mã Nhập kho</label>
                                <input type="text" name="order_code" class="form-control" id="order_code"
                                    placeholder="Nhập mã đơn hàng...">
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Chọn nhà cung cấp</label>
                                <select class="form-control select2" style="width: 100%;">
                                    {{-- <option selected="selected">Alabama</option> --}}

                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_code">Chứng từ (Mã hợp đồng,v.v...)</label>
                                <input type="text" name="order_code" class="form-control" id="order_code"
                                    placeholder="Nhập mã đơn hàng...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order_code">Chọn kho</label>
                                <input type="text" name="order_code" class="form-control" id="order_code"
                                    placeholder="Nhập mã đơn hàng...">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header ui-sortable-handle" style="cursor: move;">
                                  <h3 class="card-title">
                                    <i class="nav-icon fas fa-archive"></i>
                                    Sản phẩm
                                  </h3>

                                  <div class="card-tools">
                                    <button type="button" class="btn btn-sm btn-success float-right"><i class="fas fa-plus"></i> Thêm sản phẩm</button>
                                  </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">

                                </div>
                                <!-- /.card-body -->

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
