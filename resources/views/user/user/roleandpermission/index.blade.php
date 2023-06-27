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
                            {{-- <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Nhà cung cấp</a></li> --}}
                            <li class="breadcrumb-item active">Danh sách</li>
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
                        <tr style="text-align: center;">
                            <th rowspan="2" style="width: 10px;  vertical-align: middle;">#</th>
                            <th rowspan="2" style=" vertical-align: middle;">Vai trò</th>
                            <th colspan="4">Quyền</th>
                        </tr>
                        <tr style="text-align: center">
                            <th>Truy cập</th>
                            <th>Tạo mới</th>
                            <th>Cập nhật</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->display_name }}</td>
                                <td style="text-align: center">
                                    <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="float-right">
                    <button class="btn btn-primary">Save</button>
                </div>
              </div>
        </div>
    </div>

    @section('script')
    <script>
        $(function(s) {
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })
        })
    </script>
    @stop()
</x-layouts.main>
    