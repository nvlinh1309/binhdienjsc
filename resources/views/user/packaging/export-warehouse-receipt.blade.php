
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
            <tr>
                <td>1</td>
                <td>{{ $data->packaging->name }}</td>
                <td style="text-align: center">{{ number_format($data->contract_quantity,0,',','.') }}</td>
                <td style="text-align: center">{{ number_format($data->quantity,0,',','.') }}</td>
                <td>{{ $data->note }}</td>
            </tr>
            <tr>
                <th colspan="2">Tổng:</th>
                <th>{{ number_format($data->contract_quantity,0,',','.') }}</th>
                <th>{{ number_format($data->quantity,0,',','.') }}</th>
                <th></th>
            </tr>
        </table>
        <br>

        <div style="width:50%" class="header"></div>

        <div style="width:50%;" class="header">
            Thốt Nốt, ngày 19 tháng 09 năm 2023
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
