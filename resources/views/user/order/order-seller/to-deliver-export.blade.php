<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Don dat hang</title>
    <style>
        @font-face {
            font-family: 'TimesNewRoman';
            src: url('{{ public_path('fonts/times.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
        }

        @font-face {
            font-family: 'TimesNewRoman';
            src: url('{{ public_path('fonts/SVN-Times New Roman 2 bold.ttf') }}') format('truetype');
            font-weight: bold;
        }

        body {
            font-family: 'TimesNewRoman' !important;
            font-size: 16px;
            padding-top: 20px;
            /* padding-right: 20px; */
            /* line-height: 1; */
        }

        table {
            border-collapse: collapse;
            width: 100% !important;
        }

        td,
        th {
            border: 1px solid #000000;
            text-align: left;
            padding: 8px;
        }

        th {
            text-align: center !important;
        }

        /* tr:nth-child(even) {
            background-color: #dddddd;
        } */

        .header {
            text-align: center;
            float: left;
            height: 100px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            padding-bottom: 20px;
            line-height: 0.8 !important;
        }

        .content {
            padding-top: 60px;
            /* padding-left: 20px; */

            width: 100%;
        }
    </style>
</head>

<body>
    <div>
        <div style="width:40%" class="header"><strong>CÔNG TY CỔ PHẦN BÌNH ĐIỀN</strong></div>
        <div style="width: 40%" class="header">
            <div class="title">PHIẾU XUẤT KHO<br>
                <label style="font-size: 16px; font-weight:normal; line-height: 0.8 !important;">
                Số: {{ $data->to_deliver_code }}<br>
                Ngày {{ date('d',strtotime($data->to_deliver_date)) }} tháng {{ date('m',strtotime($data->to_deliver_date)) }} năm {{ date('Y',strtotime($data->to_deliver_date)) }}
            </label>
            </div>
        </div>
        <div style="width: 20%" class="header">
            <strong>SPN: {{ $data->id }}</strong>
        </div>
    </div>




    <div class="content">

        <div>
            <strong  style="width: 200px">Đơn vị nhận hàng:</strong>
            {{ $data->customer->name }}
        </div>
        <div>
            <strong  style="width: 200px">Theo chứng từ:</strong>
            <strong>HĐ: {{ $data->customer->code }}</strong>
        </div>

        <div>
            <strong  style="width: 200px">Nhập tại kho:</strong>
            <label style="width: 500px">{{ $data->storage->name }}.</label>

            <strong  style="width: 100px">     Địa chỉ:</strong>
            {{ $data->storage->address }}
        </div>

        <div>
            <strong  style="width: 200px">Thông tin giao nhận:</strong>
            {{ $data->to_deliver_info??"..................................................." }}

            <strong  style="width: 100px">Xe/Cont:</strong>
            {{ $data->to_deliver_transport??"..................................." }}
        </div>
        <br>
        <table>
            <tr>
                <th style="width: 30px">STT</th>
                <th style="">Tên sản phẩm hàng hoá</th>
                <th style="width: 30px">Quy cách đóng gói/kg</th>
                <th style="width: 30px">Đơn vị tính</th>
                <th style="width: 50px">Lô hàng</th>
                <th style="width: 50px">Hạn sử dụng</th>
                <th style="width: 50px">Khối lượng (Kg)</th>
                <th style="width: 50px">Số lượng bao</th>
                <th style="">Ghi chú</th>
            </tr>
            @php
                $quantity = 0;
                $bag_quantity = 0;
            @endphp
            @foreach ($products as $key=>$product)
                @php
                    $quantity += $product['quantity'];
                    $bag_quantity += $product['quantity']*$product['specification'];
                @endphp
                <tr>
                    <td style="text-align: center">{{ $key+1 }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td style="text-align: center">{{ $product['specification'] }}</td>
                    <td style="text-align: center">{{ strtoupper($product['unit']) }}</td>
                    <td style="text-align: center">{{ date('dmY',strtotime($data->to_deliver_date)) }}</td>
                    <td style="text-align: center">{{ date('d/m/Y',strtotime($data->to_deliver_date)) }}</td>
                    <td style="text-align: center">{{ number_format($product['quantity']*$product['specification'], 0, ',', '.')}}</td>
                    <td style="text-align: center">{{ number_format($product['quantity'], 0, ',', '.')}}</td>
                    <td>{{ $product['note'] }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="6">Tổng cộng:</th>
                <th>{{ number_format($bag_quantity, 0, ',', '.')}}</th>
                <th>{{ number_format($quantity, 0, ',', '.')}}</th>
                <th></th>
            </tr>
        </table>
        <br>

        <div style="width:25%; float: left;font-weight:bold">
            Người Lập Phiếu
            <br>
            <br>
            <br>
            <br>
            <br>
            {{ $data->createdBy->name}}
        </div>

        <div style="width:25%; float: left;font-weight:bold">
            Bộ phận giao nhận
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>

        <div style="width:25%; float: left;font-weight:bold">
            Thủ Kho Hàng
            <br>
            <br>
            <br>
            <br>
            <br>
            {{ $data->warehouseKeeper->name }}
        </div>

        <div style="width:25%; float: left;font-weight:bold">
            Phụ trách Tổ KD
            <br>
            <br>
            <br>
            <br>
            <br>
            {{ $data->user_order_approver->name }}
        </div>

        <div style="font-weight:bold">
            Người nhận hàng
            <br>
            <br>
            <br>
            <br>
            <br>
            Thời gian nhận hàng:.............................
        </div>
    </div>




</body>

</html>
