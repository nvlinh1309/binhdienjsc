<x-layouts.main>
    @section('content_header')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Lịch sử cập nhật</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Sản phẩm</a></li>
                            <li class="breadcrumb-item active"><a
                                    href="{{ route('product.show', $data->id) }}">{{ $data->name }}</a></li>
                            <li class="breadcrumb-item active">Lịch sử</li>
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Danh sách cập nhật
                </h3>

                <div class="card-tools">
                    {{ $history->links('vendor.pagination.default') }}
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Tên sản phẩm</th>
                            <th>Barcode</th>
                            <th>Quy cách</th>
                            <th>Đơn vị tính</th>
                            <th>Giá sản phẩm (VNĐ)</th>
                            <th>Tên thương hiệu</th>
                            <th>Ngày tạo</th>
                            <th>Người tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Người cập nhật</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($history as $key => $storageDetail)
                            <tr>
                                <td>{{ ($history->currentpage() - 1) * $history->perpage() + $key + 1 }}</td>
                                <td>{{ $storageDetail->name }}</td>
                                <td>{{ $storageDetail->barcode }}</td>
                                <td>{{ $storageDetail->specification }}</td>
                                <td>{{ $storageDetail->unit }}</td>
                                <td>{{ $storageDetail->price }}</td>
                                <td>{{ $storageDetail->brand_name }}</td>
                                <td>{{ $storageDetail->created_at }}</td>
                                <td>{{ $storageDetail->user_created ? $storageDetail->user_created->name : '' }}</td>
                                <td>
                                    {{ $storageDetail->updated_at }}
                                </td>
                                <td>
                                    {{ $storageDetail->user_updated ? $storageDetail->user_updated->name : '' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</x-layouts.main>
