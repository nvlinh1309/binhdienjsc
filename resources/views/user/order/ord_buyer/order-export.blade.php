<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đơn đặt hàng</title>
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
            line-height: 1;
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
        }

        .title {
            width: 100%;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            padding-top: 60px;
            padding-bottom: 20px;
            line-height: 0.8 !important;
        }

        .content {
            padding-left: 20px;
            padding-right: 20px;
        }
    </style>
</head>

<body>
    <div style="width:40%" class="header"><strong>CÔNG TY CỔ PHẦN BÌNH ĐIỀN</strong><br> *****</div>
    <div style="width: 60%" class="header"><strong>CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong><br>Độc lập - Tự do - Hạnh
        phúc<br>*****</div>
    <br>
    <div class="title">
        ĐƠN ĐẶT HÀNG
        <br>
        <label style="font-size: 18px">Số: {{ $data->code }}</label>
    </div>
    <div style="padding-left: 20%; padding-bottom:20px">
        Kính gửi: <strong>{{ $data->supplier->name }}</strong><br>
        Địa chỉ: {{ $data->supplier->address }}
    </div>

    <div class="content">
        <div><strong>Đơn vị mua hàng:</strong> {{ $data->company_name }}</div>
        <div>Địa chỉ: {{ $data->company_address }}</div>
        <div>Mã số thuế: {{ $data->company_tax }}</div><br>
        <div>Nội dung đơn hàng:</div>
        <strong>1. MẶT HÀNG - SỐ LƯỢNG - ĐƠN GIÁ</strong>

        <table>
            <tr>
                <th style="width: 30px">STT</th>
                <th style="">MẶT HÀNG</th>
                <th style="width: 50px">Quy cách bao bì</th>
                <th style="width: 70px">SỐ LƯỢNG (KG)</th>
                <th style="width: 70px">ĐƠN GIÁ (vnđ/kg)</th>
                <th style="width: 80px">THÀNH TIỀN<br> (vnđ)</th>
                <th style="width: 100px">GHI CHÚ</th>
            </tr>
            @php
                $quantity = 0;
                $price = 0;
            @endphp
            @foreach ($data->products as $key=>$product)
            @php
                $quantity += $product->product_quantity;
                $price += $product->product_quantity*$product->product_price;
            @endphp
                <tr>
                    <td style="text-align: center">{{ $key+1 }}</td>
                    <td>{{ $product->product->name }}</td>
                    <td>{{ $product->product->specification.strtoupper($product->product->unit)  }}</td>
                    <td style="text-align: center">{{ number_format($product->product_quantity, 0, ',', '.')}}</td>
                    <td style="text-align: center">{{ number_format($product->product_price, 0, ',', '.')}}</td>
                    <td style="text-align: center">{{ number_format($product->product_quantity*$product->product_price, 0, ',', '.')}}</td>
                    <td></td>
                </tr>
            @endforeach
            <tr>
                <th colspan="3">Tổng cộng:</th>
                <th>{{ number_format($quantity, 0, ',', '.')}}</th>
                <th></th>
                <th>{{ number_format($price, 0, ',', '.')}}</th>
                <th></th>
            </tr>
        </table>
        <br>
        <div><strong>Bằng chữ: </strong>{{numberInVietnameseCurrency($price)}}./.</div>
        <div>Đơn hàng trên chưa bao gồm phí vận chuyển nếu nhận hàng tại kho {{$data->storage->name}}.</div>
        <div>- Giá trên được căn cứ vào Hợp đồng số {{ $data->supplier->supplier_code }} ngày {{ date('d/m/Y', strtotime($data->supplier->contract_signing_date)) }}</div>

        <strong>2. KẾ HOẠCH VÀ NƠI NHẬN HÀNG</strong>
        <div>- Thời gian dự kiến giao hàng: {{ $data->estimated_delivery_time }}</div>
        <div>Rất mong Quý Công ty xem xét và trả lời sớm.</div>
        <div>Trân trọng./.</div>
        <br>

        <div style="width:60%" class="header"></div>

        <div style="width:40%; font-weight:bold" class="header">
            ĐƠN VỊ ĐẶT HÀNG
            <br>
            <br>
            <br>
            <br>
            <br>
            {{ $data->approvedBy->name}}
        </div>
    </div>




</body>

</html>
