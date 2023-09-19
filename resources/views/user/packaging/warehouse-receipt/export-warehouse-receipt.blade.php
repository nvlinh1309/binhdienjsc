
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
    <div style="float: left; width:80px">
        <img src="{{ public_path('images/logo-ngocquangphat.png') }}" alt="" width="60px">

    </div>
    <div style="float: left; width:600px">
        CÔNG TY CỔ PHẦN XNK NGỌC QUANG PHÁT </br>
        Add: KV Long Thạnh A, P.Thốt Nốt, Q.Thốt Nốt, TP.Cần Thơ</br>
        Tel: (0710) 3611 622 - Fax: (0710) 3611 622</br>

    </div>
    <div class="title">
        PHIẾU NHẬP KHO BAO BÌ
        <br> <small>Số: {{ $info->lot }}</small>
    </div>

    <div class="content">
        <div>Nơi xuất kho:.......................................................................................</div>
        <div>Lý do xuất kho:....................................................................................</div>
        <br>
        <table>
            <tr>
                <th style="width: 30px">STT</th>
                <th style="">Tên bao bì</th>
                <th style="">Số lượng (cái)) <br>(Hợp đồng)</th>
                <th style="">Số lượng (cái)<br>(Thực nhận)</th>
                <th style="">Ghi chú</th>
            </tr>
            @php
                $sum_quantity = 0;
                $sum_contract_quantity = 0;
            @endphp
            @foreach ($data as $key=>$value)
                @php
                    $sum_quantity += $value->quantity;
                    $sum_contract_quantity += $value->contract_quantity;
                @endphp
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $value->packaging->name }}</td>
                    <td style="text-align: center">{{ number_format($value->contract_quantity,0,',','.') }}</td>
                    <td style="text-align: center">{{ number_format($value->quantity,0,',','.') }}</td>
                    <td>{{ $value->note }}</td>
                </tr>
            @endforeach

            <tr>
                <th colspan="2">Tổng:</th>
                <th>{{ number_format($sum_contract_quantity,0,',','.') }}</th>
                <th>{{ number_format($sum_quantity,0,',','.') }}</th>
                <th></th>
            </tr>
        </table>
        <br>

        <div style="width:50%" class="header"></div>

        <div style="width:50%;" class="header">
            Thốt Nốt, ngày {{ date('d')}} tháng {{ date('m') }} năm {{ date('Y') }}
            <div style="font-weight:bold">Lập phiếu</div>
            <br>
            <br>
            <br>
            <br>
            <br>

        </div>
    </div>




</body>

</html>
