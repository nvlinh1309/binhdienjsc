<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Bao bì</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('packaging.index') }}">Bao bì</a></li>
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
        @if (\Session::has('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {!! \Session::get('error') !!}
            </div>
        @endif
    </div>
    <div class="col-md-12 float-right">
        <p class="mb-2 float-right"><a class="link-opacity-100" href="#">Lịch
                sử</a></p>
    </div>
    <div class="col-md-12">
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Thông tin</h5>
            <div><b>Mã:</b> BB{{ sprintf("%03d",$data->id) }}</div>
            <div><b>Tên bao bì:</b> {{ $data->name }}</div>
            <div><b>Tồn kho:</b> {{ $data->getDetail->sum('in_stock') }}</div>
            <hr>

            {{-- <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Quay lại</button> --}}
            @can('product-edit')
                <button class="btn btn-warning" onclick="window.location='{{ route('packaging.edit', $data->id) }}'">Chỉnh
                    sửa</button>
            @endcan
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Chi tiết
                </h3>

                {{-- <div class="card-tools">
                    <a href="{{ route('packaging.get-input', $data->id) }}" class="btn btn-sm btn-primary">Nhập kho</a>
                </div> --}}
            </div>
            <!-- /.card-header -->

            <div class="card-body p-0">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Lô nhập</th>
                            <th>Ngày nhập</th>
                            <th>Số lượng</th>
                            <th>Còn lại</th>
                            <th>Xuất kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($data->getDetail)>0)
                            @foreach ($data->getDetail as $key=>$value)
                                <tr>
                                    <td>{{ $value->lot }}</td>
                                    <td>{{ $value->created_at }}</td>
                                    <td>{{ $value->quantity }}</td>
                                    <td>{{ $value->in_stock }}</td>
                                    <td><a href="#">Xem</a></td>
                                </tr>
                            @endforeach

                        @else
                        <tr>
                            <td colspan="4">Chưa có dữ liệu</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>


            <!-- /.card-body -->
        </div>
    </div>
    <script>

    </script>
</x-layouts.main>
