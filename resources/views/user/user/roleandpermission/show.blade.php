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
                            <li class="breadcrumb-item active">{{ $role->display_name }}</li>
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
        <div class="alert alert-info alert-dismissible fade d-none alert-permission" role="alert">
            <span class="permission-text">You should check in on some of those fields below.</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

    <div class="col-md-12">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tag"></i>
                        {{ $role->display_name }}
                    </h3>
                </div>
                @if (count($parentPermissions))
                    <input type="hidden" id="role_id" value="{{ $role->id }}" />
                    @foreach ($parentPermissions as $perssionArray)
                        <div class="card-body">
                            <div class="col-12">
                                <h5>{{ $perssionArray->parent_name }}</h5>
                                <hr>
                            </div>
                            @if ($perssionArray->permissions)
                                @foreach ($perssionArray->permissions as $permission)
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="@can('role-edit') input-permission @endcan" name="" @if($role->name == 'admin') disabled @endif
                                                id="" value="{{ $permission->name }}"
                                                @if ($role->hasPermissionTo($permission->name)) checked @endif>
                                            {{ $permission->display_name }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {

            $('.input-permission').on('change', function(e) {
                var permission = $(this).val();
                var roleId = $('#role_id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('users.role.set') }}",
                    data: {
                        'role_id': roleId,
                        'permission_nm': permission
                    },
                    cache: false,
                    success: function(data) {
                        if (data.status_respone == true) {
                            $('.permission-text').html(data.message);
                            $('.alert-permission').removeClass('d-none');
                            $('.alert-permission').addClass('show');
                        }
                    }
                });

            });
        });
    </script>
</x-layouts.main>
