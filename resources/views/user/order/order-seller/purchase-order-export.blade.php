{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đơn đặt hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>

        body {
            font-family: 'TimesNewRoman' !important;
            /* line-height: 1.5; */
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
</html> --}}


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
        <div><strong>Đơn vị mua hàng:</strong> {{ $order_info->buyer_name }}</div>
        <div>Địa chỉ: {{ $order_info->buyer_address }}</div>
        <div>Mã số thuế: {{ $order_info->buyer_tax_code }}</div><br>
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
            @foreach ($products as $key=>$product)
            @php
                $quantity += $product['quantity'];
                $price += $product['quantity']*$product['price'];
            @endphp
                <tr>
                    <td style="text-align: center">{{ $key+1 }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['specification'].strtoupper($product['unit'])  }}</td>
                    <td style="text-align: center">{{ number_format($product['quantity'], 0, ',', '.')}}</td>
                    <td style="text-align: center">{{ number_format($product['price'], 0, ',', '.')}}</td>
                    <td style="text-align: center">{{ number_format($product['quantity']*$product['price'], 0, ',', '.')}}</td>
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
        <div><strong>Bằng chữ: </strong>{{numberInVietnameseCurrency(135000000)}}./.</div>
        <div>Đơn hàng trên chưa bao gồm phí vận chuyển nếu nhận hàng tại kho {{$data->storage->name}}.</div>
        <div>- Giá trên được căn cứ vào Hợp đồng số {{ $data->supplier->supplier_code }} ngày {{ date('d/m/Y', strtotime($data->supplier->contract_signing_date)) }}</div>

        <strong>2. KẾ HOẠCH VÀ NƠI NHẬN HÀNG</strong>
        <div>- Thời gian dự kiến giao hàng: {{ $order_info->estimate_delivery_time }}</div>
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
            {{ $data->user_order_approver->name}}
        </div>
    </div>




</body>

</html>
