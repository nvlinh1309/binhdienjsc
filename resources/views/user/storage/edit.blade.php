<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kho</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('store.index') }}">Kho</a></li>
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
    </div>
    <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cập nhật thông tin kho <strong>{{ $data->name }}</strong></h3>
            </div>

            <form id="update" action="{{ route('store.update', $data->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="code">Mã kho</label>
                                <input type="text" name="code" value="{{ $data->code }}" class="form-control"
                                    id="code" placeholder="Nhập mã kho...">
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Tên kho</label>
                                <input type="text" name="name" value="{{ $data->name }}" class="form-control"
                                    id="name" placeholder="Nhập tên kho...">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input type="text" name="address" value="{{ $data->address }}" class="form-control"
                                    id="address" placeholder="Nhập địa chỉ...">
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('store.index') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

</x-layouts.main>
