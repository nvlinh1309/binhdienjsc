<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Vai trò và quyền</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('users.indexRaP') }}">Danh sách</a></li>
                            <li class="breadcrumb-item active">{{ $data->display_name }}</li>
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
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tag"></i>
                        {{ $data->display_name }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <h5>Quản lý quyền và vai trò</h5>
                        <hr>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="" id=""
                                value="checkedValue">
                            Truy cập
                        </label>
                    </div>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="" id=""
                                value="checkedValue">
                            Cập nhật
                        </label>
                    </div>

                </div>

                <div class="card-body">
                    <div class="col-12">
                        <h5>Quản lý người dùng</h5>
                        <hr>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="" id=""
                                value="checkedValue">
                            Truy cập
                        </label>
                    </div>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="" id=""
                                value="checkedValue">
                            Thêm mới
                        </label>
                    </div>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="" id=""
                                value="checkedValue">
                            Chỉnh sửa
                        </label>
                    </div>

                </div>

                <div class="card-body">
                    <div class="col-12">
                        <h5>Quản lý kho</h5>
                        <hr>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="" id=""
                                value="checkedValue">
                            Truy cập
                        </label>
                    </div>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="" id=""
                                value="checkedValue">
                            Thêm mới
                        </label>
                    </div>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="" id=""
                                value="checkedValue">
                            Chỉnh sửa
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="" id=""
                                value="checkedValue">
                            Xoá
                        </label>
                    </div>

                </div>

            </div>

        </div>

    </div>
</x-layouts.main>
