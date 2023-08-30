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
        <!-- jquery validation -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cập nhật thông tin người dùng <strong>{{ $data->name }}</strong></h3>
            </div>

            <form id="update" action="{{ route('users.update', $data->id) }}" method="POST">
                <input type="hidden" value="{{$data->id}}" name="id"/>
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Họ tên</label><span class="text-danger">*</span>
                                <input type="text"  name="name"  value="{{ old('name', $data->name) }}"  class="form-control" id="name"
                                    placeholder="Nhập họ tên...">
                                     @if ($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Email</label><span class="text-danger">*</span>
                                <input type="text" readonly name="email" value="{{ old('email', $data->email) }}"  class="form-control"
                                    id="email" placeholder="Nhập email...">
                                    @if ($errors->has('email'))
                                    <div class="error text-danger">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="role">Vai trò</label><span class="text-danger">*</span>
                                <select  class="form-control select2" name="role"
                                    data-placeholder="Chọn vai trò" id="role" style="width: 100%;" >
                                    <option value=""></option>
                                    @foreach ($roles as $role) 
                                        <option value="{{ $role->name }}" {{ $role->name == old('role', $data->getRoleNames()[0]) ? 'selected' : '' }}>{{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                                 @if ($errors->has('role'))
                                    <div class="error text-danger">{{ $errors->first('role') }}</div>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('users.show', $data->id) }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

</x-layouts.main>
