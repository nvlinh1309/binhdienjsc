<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đơn đặt hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        @font-face {
            font-family: 'TimesNewRoman';
            src: url('{{ public_path("fonts/times.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
        }

        @font-face {
            font-family: 'TimesNewRoman';
            src: url('{{ public_path("fonts/SVN-Times New Roman 2 bold.ttf") }}') format('truetype');
            font-weight: bold;
        }

        body {
            font-family: 'TimesNewRoman' !important;
            line-height: 1.5;
        }
        table, th, td {
            width: 100%;
            border: 1px solid #000000;
            text-align: center;
        }
    </style>
</head>
<body>
    <div style="width:50%; float:left; text-align:center">
        <div style="font-weight: 700">CÔNG TY CỔ PHẦN BÌNH ĐIỀN</div>
        *****

    </div>
    <div style="width:50%; float:left; text-align:center">
        <div style="font-weight: 700">CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM </div>
        <div>Độc lập - Tự do - Hạnh phúc</div>
        *****

    </div>
    <div style="width:100%; text-align:center; font-size:24px; font-weight:bold;">
        <div >
            ĐƠN ĐẶT HÀNG
        </div>
        <div style="line-height: 1;font-size:20px;">
            Số: {{$data->code}}
        </div>
    </div>
    <div style="margin-top: 15px; margin-left:25%">
        <div>Kính gửi: <strong>{{ $data->supplier->name}}</strong><br>
            Địa chỉ: {{ $data->supplier->address }}</div>
    </div>
    <div style="width: 100%; margin-top:15px; padding-left:20px; padding-right:20px">
        <div><strong>Đơn vị mua hàng:</strong> {{ $order_info->buyer_name}}</div>
        <div>Địa chỉ: {{ $order_info->buyer_address}}</div>
        <div>Mã số thuế: {{ $order_info->buyer_tax_code}}</div><br>
        <div>Nội dung đơn hàng:</div>
            <strong>1. MẶT HÀNG - SỐ LUỌNG - ĐƠN GIÁ</strong>
        <table>
            <tr>
                <th style="width: 50px">STT</th>
                <th style="">MẶT HÀNG</th>
                <th style="width: 50px">Quy cách bao bì</th>
                <th style="width: 70px">SỐ LƯỢNG (KG)</th>
                <th style="width: 100px">ĐƠN GIÁ (vnđ/kg)</th>
                <th style="width: 100px">THÀNH TIỀN (vnđ)</th>
                <th style="width: 100px">GHI CHÚ</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ number_format(100000, 0, ',', '.')}}</td>
                <td>{{numberInVietnameseCurrency(100000)}}</td>
                <td></td>
            </tr>
        </table>
    </div>
</body>
</html>
