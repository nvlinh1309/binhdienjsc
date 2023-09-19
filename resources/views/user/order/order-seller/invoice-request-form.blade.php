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
            font-size: 18px;
        }

        .title {
            width: 100%;
            font-size: 20px;
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
    <div style="width: 100%" class="header"><strong>CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong><br>Độc lập - Tự do - Hạnh
        phúc<br>*****</div>
    <br>
    <div class="title">
        GIẤY ĐỀ NGHỊ XUẤT HOÁ ĐƠN
    </div>
    <div style="padding:0px 20px 0px 20px ; font-size:18px; text-align:center">
        <strong>Kính gửi: Phòng Tài Chính Kế Toán - Công ty cổ phần Bình Điền</strong><br>
    </div>

    <div style="padding: 20px;">
        - Căn cứ theo kế hoạch bán hàng của Tổ Kinh doanh Gạo và nhu cầu mua hàng của khách hàng.
    </div>

    <div class="content">
        <div>Tổ Kinh doanh Gạo - Công ty CP Bình Điền đề nghị Phòng Tài chính – Kế toán xuất hóa đơn cho đơn hàng với thông tin như sau:</div>
        <div>* Thông tin xuất hoá đơn:</div>
        <div style="padding: 0 20px">
            - Tên khách hàng: <strong>{{ $data->customer->name }}</strong><br>
            - Mã số thuế: {{ $data->customer->tax_code }}<br>
            - Địa chỉ: {{ $data->customer->address }}<br>
            - Địa chỉ email nhận hoá đơn điện tử: <strong>{{ $data->customer->contact['email'] }}</strong><br>
            - Ngày xuất hoá đơn: ........................................<br><br>
        </div>

        <table>
            <tr>
                <th style="width: 30px">STT</th>
                <th>Tên hàng hoá, dịch vụ</th>
                {{-- <th style="">Nội dung</th> --}}
                <th style="width: 50px">Thương hiệu</th>
                <th style="width: 70px">ĐVT</th>
                <th style="width: 50px">Quy cách bao</th>
                <th style="width: 50px">Số lượng bao</th>
                <th style="width: 90px">Đơn giá bao</th>
                <th style="width: 90px">Thành tiền<br>(VNĐ)</th>
            </tr>
            @php
                $quantity = 0;
                $price = 0;
            @endphp
            @foreach ($products as $key=>$product)
            @php
                $price += $product['quantity']*$product['price'];
            @endphp
                <tr>
                    <td style="text-align: center">{{ $key+1 }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>Quang Phát</td>
                    <td style="text-align: center">{{ strtoupper($product['unit']) }}</td>
                    <td style="text-align: center">{{ $product['specification'] }}</td>
                    <td style="text-align: center">{{ number_format($product['quantity'], 0, ',', '.')}}</td>
                    <td style="text-align: center">{{ number_format($product['price'], 0, ',', '.')}}</td>
                    <td style="text-align: center">{{ number_format($product['price']*$product['quantity'], 0, ',', '.')}}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="7">Tổng:</th>
                <th>{{ number_format($price, 0, ',', '.')}}</th>
            </tr>
        </table>
        <br>
        <div>Tổng thành tiền chưa thuế: {{ number_format($price, 0, ',', '.')}} đồng.</div>
        <div>Tổng tiền thuế (thuế suất: {{ $data->customer->tax }}%): {{ number_format(($price*$data->customer->tax)/100, 0, ',', '.')}} đồng.</div>
        <div>Tổng thành tiền đã thuế: {{ number_format($price+(($price*$data->customer->tax)/100), 0, ',', '.') }} đồng.</div>
        {{-- <div>* Địa chỉ nhận hoá đơn điện tử: <strong>{{ $data->customer->contact['email'] }}</strong></div> --}}
        <div>(Bằng chữ: {{numberInVietnameseCurrency($price+(($price*$data->customer->tax)/100)) }}./.)</div>
        <br>

        <div style="width:30%" class="header"></div>

        <div style="width:60%; font-weight:bold" class="header">
            TỔ TRƯỞNG TỔ KINH DOANH GẠO
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
