<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Người dùng</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Danh sách</a></li>
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
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Thông tin</h5>
            <div><b>Tên:</b> {{ $data->name }}</div>
            <div><b>Emmail:</b> {{ $data->email }}</div>
            <div><b>Vai trò:</b> {{ $data->roles[0]->display_name??"" }}</div>
            <div><b>Ngày tạo:</b> {{ $data->created_at }}</div>
            <div><b>Ngày cập nhật cuối cùng:</b> {{ $data->updated_at ?? $data->created_at }}</div>
            <br>
            <button class="btn btn-secondary" onclick="window.location='{{ route('users.index') }}'">Quay lại</button>
            @can('role-edit')
            <button class="btn btn-warning" onclick="window.location='{{ route('users.edit', $data->id) }}'">Chỉnh
                sửa</button>
            @endcan
        </div>

    </div>

</x-layouts.main>
