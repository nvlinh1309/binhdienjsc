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
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th style="width:60px">#</th>
                        <th>Role</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key=>$value)
                        <tr>
                            <td>{{ ($data->currentpage()-1) * $data->perpage() + $key + 1 }}</td>
                            <td>{{ $value->display_name }}</td>
                            <td class="text-center"><a href="{{ route('users.showRaP', $value->id) }}">Xem</a></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
       
    </div>
</div>
</x-layouts.main>
    