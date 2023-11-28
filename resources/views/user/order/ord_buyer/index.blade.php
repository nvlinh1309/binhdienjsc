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
            <div class="card-header">
                <h3 class="card-title">
                    <a href="{{ route('order-buyer.create') }}">
                        <button class=" btn btn-sm btn-primary" title="Khởi tạo đơn hàng">Khởi tạo đơn hàng</button>
                    </a>
                   <select id="status" style= "min-width: 300px;
                   padding: 2px;
                   position: absolute;
                   margin-left: 10px;
                   border: solid 1px #0004;
                   border-radius: 5px;">
                        <option value="">Tất cả trạng thái</option>
                       @foreach ($statusList as $index=>$item)
                        <option value="{{$index}}" {{ app('request')->input('status') ? (app('request')->input('status') == $index ? 'selected' : ''):""}}>{{$item}}</option>
                       @endforeach
                   </select>
                </h3>

                <div class="card-tools">
                    <a href="" class="btn btn-sm btn-outline-secondary">Đơn hàng đã huỷ</a>
                </div>


            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="card-tools">
                    {{ $data->links('vendor.pagination.default') }}
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Mã ĐH</th>
                            <th>NCC</th>
                            <th>Ngày tạo đơn</th>
                            <th>Trạng thái</th>
                            <th style="width: 100px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $num = 1; ?>
                        @foreach ($data as $key => $value)
                            <tr>
                                <td>{{ ($data->currentpage() - 1) * $data->perpage() + $key + 1 }}</td>
                                <td>{{ $value->code }}</td>
                                <td>{{ $value->supplier->name }}</td>
                                <td>{{ $value->created_at }}</td>
                                <td><i class="badge {{ $statusColor[$value->status] }}">{{ $value->status ? $statusList[$value->status] : '' }}</i></td>
                                <td>
                                    <a href="{{ route('order-buyer.show', $value->id) }}"
                                        class="btn btn-xs btn-success">Chi tiết</a>
                                </td>
                            </tr>
                            <?php $num++; ?>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <script>
        $("#status").on('change', function(){
            window.location.href = "{{ route('order-buyer.index')}}?status="+$(this).val();
        })
    </script>
</x-layouts.main>
