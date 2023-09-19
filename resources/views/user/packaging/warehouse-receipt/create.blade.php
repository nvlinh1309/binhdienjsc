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
                            <li class="breadcrumb-item"><a href="{{ route('warehouse-receipt.index') }}">Danh sách phiếu nhập kho</a></li>
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
                <h3 class="card-title">Nhập kho</h3>
            </div>

            <form id="quickForm" action="{{ route('warehouse-receipt.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name">Chọn kho</label> <span class="text-danger">(*)</span>
                                <select class="form-control select2" name="storage_id" style="width: 100%;">
                                    @foreach ($wareHouses as $wareHouse)
                                        <option value="{{ $wareHouse->id }}"
                                            {{ $wareHouse->id == old('storage_id') ? 'selected' : '' }}>
                                            {{ $wareHouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="packaging_id">Chọn bao bì</label>
                                <select class="form-control select2" id="packaging_id" style="width: 100%;" >
                                    @foreach ($packaging as $value)
                                        <option data-name="{{ $value->name }}" value="{{ $value->id }}"
                                            {{ $value->id == old('packaging_id') ? 'selected' : '' }}>
                                            {{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="contract_quantity">Số lượng (cái) (Hợp đồng)</label>
                                <input value="{{ old('contract_quantity') }}" type="text" id="contract_quantity" class="form-control {{ $errors->has('contract_quantity')?"is-invalid":"" }}" id="name"
                                    placeholder="Nhập số lượng (Hợp đồng)...">
                                     @if ($errors->has('contract_quantity'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('quantity') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="quantity">Số lượng (cái) (Thực nhận)</label>
                                <input value="{{ old('quantity') }}" type="text" id="quantity" class="form-control {{ $errors->has('quantity')?"is-invalid":"" }}" id="name"
                                    placeholder="Nhập số lượng (Thực nhận)...">
                                     @if ($errors->has('quantity'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('quantity') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="note">Ghi chú</label>
                                <input value="{{ old('note') }}" type="text" id="note" class="form-control {{ $errors->has('note')?"is-invalid":"" }}" id="name"
                                    placeholder="Nhập ghi chú...">
                                     @if ($errors->has('note'))
                                    <div class="error text-danger invalid-feedback-custom">{{ $errors->first('note') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="btn btn-sm btn-success" id='btn-add'>Thêm</label>
                        </div>

                        <div class="col-sm-12 ">
                            <table class="table">
                                <thead>
                                    <tr class="text-center">
                                        <th>Tên bao bì</th>
                                        <th>Số lượng (cái)<br>(Hợp đồng)</th>
                                        <th>Số lượng (cái)<br>(Thực nhận)</th>
                                        <th>Ghi chú</th>
                                        <th>Xoá</th>
                                    </tr>
                                </thead>
                                <tbody id="packagings">
                                    <tr>
                                        <td colspan="5"><i class="text-danger">Vui lòng thêm ít nhất 1 bản ghi</i></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <input type="hidden" name="packaging" class="form-control" id="packaging">
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary disabled btn-submit">Xác nhận</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>

    <script>
        $(document).ready(function() {
            $('#btn-add').on('click', function(e) {

                let packagings = $("#packaging").val();
                let data = [];
                if (packagings != "") {
                    data = JSON.parse(packagings);
                }

                let packaging_id = $("#packaging_id").val();
                let packaging_name = $("#packaging_id").find(":selected").attr("data-name");
                // let packaging_id = $("#packaging_id").val();
                let contract_quantity = $("#contract_quantity").val();
                let quantity = $("#quantity").val();
                let note = $("#note").val();

                data.push({
                    'packaging_id':packaging_id,
                    'contract_quantity':contract_quantity,
                    'quantity':quantity,
                    'note':note,
                    'packaging_name':packaging_name
                });

                $("#packaging").val(JSON.stringify(data));
                let html = '';
                data.forEach(function (element,i) {
                    html += '<tr class="delete_'+i+'"><td>'+element.packaging_name+'</td><td>'+element.contract_quantity+'</td><td>'+element.quantity+'</td><td>'+element.note+'</td><td><label class="btn btn-sm btn-danger delete" data-id="'+i+'">Xoá</label></td></tr>';

                });
                console.log(html);
                $(".btn-submit").removeClass('disabled');
                $("#packagings").html(html);
            });

            $(document).on("click",".delete", function(){
                let data = JSON.parse($("#packaging").val());
                let id = $(this).data("id");
                let html = '';
                let array = [];
                data.forEach(function (element,i) {

                    if (i != id) {
                        array.push(element);
                        html += '<tr class="delete_'+i+'"><td>'+element.packaging_name+'</td><td>'+element.contract_quantity+'</td><td>'+element.quantity+'</td><td>'+element.note+'</td><td><label class="btn btn-sm btn-danger delete" data-id="'+i+'">Xoá</label></td></tr>';
                    }
                });
                $("#packaging").val(JSON.stringify(array));
                if (array.length == 0) {
                    $(".btn-submit").addClass('disabled');
                    html = ' <tr><td colspan="5"><i class="text-danger">Vui lòng thêm ít nhất 1 bản ghi</i></td></tr>';
                }
                console.log(html);
                $("#packagings").html(html);
            })
        });



    </script>

</x-layouts.main>
