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
                            <li class="breadcrumb-item"><a href="{{ route('packaging.index') }}">Danh sách</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('packaging.show', $data->id) }}">{{ $data->name }}</a></li>
                            <li class="breadcrumb-item active">Nhập kho</li>
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
        <!-- jquery validation -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Nhập kho bao bì: {{ $data->name }}</h3>
            </div>

            <form id="quickForm" action="{{ route('packaging.post-input', $data->id) }}" method="POST">
                @csrf
                <input type="hidden" name="packaging_id" value="{{ $data->id }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Chọn kho</label><span class="text-danger">*</span>
                                <select class="form-control select2" name="storage_id" style="width: 100%;">
                                    @foreach ($wareHouses as $wareHouse)
                                        <option value="{{ $wareHouse->id }}"
                                            {{ $wareHouse->id == old('storage_id') ? 'selected' : '' }}>
                                            {{ $wareHouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="quantity">Số lượng</label><span class="text-danger">*</span>
                                <input value="{{ old('quantity') }}" type="text" name="quantity" class="form-control {{ $errors->has('quantity')?"is-invalid":"" }}" id="name"
                                    placeholder="Nhập số lượng...">
                                     @if ($errors->has('quantity'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('quantity') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

</x-layouts.main>
