<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
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

        tr:nth-child(even) {}

        /* Style the header */
        .header {
            background-color: #f1f1f1;
            padding: 20px;
            text-align: center;
        }

        body {
            margin: 20px;
            margin-top: 20px;
            padding: 10px;
        }

        div#container {
            background: white;
            padding: 5px;
        }

        .main-header {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }

        .main-header .first {
            border: 1px solid black;
            width: 33%;
            float: left;
            text-align: center;
        }

        .main-header .second {
            border: 1px solid black;
            width: 33%;
            float: right;
            text-align: center;
        }

        .main-header .spn {
            border: 1px solid black;
            width: 33%;
            float: right;
        }

        .sub-header {
            width: 100%;
            text-align: center;
            display: flex;
        }

        .sub-header p {
            width: 100%;
        }

        table {
            border: none;
        }

        .second-div table {
            font-size: 9px;
            border: 0;
        }

        .second-div table td,
        .second-div table tr {
            border: none;
        }

        .second-div table .bLeft {
            font-weight: bold;
        }

        .second-div table .middle {
            font-size: 11px;
        }

        .footer-div {
            margin-top: 20px;
        }

        .inner {
            width: 25%;
            box-sizing: border-box;
            float: left;
            text-align: center;
            padding: 16px;
        }

        .main-div {
            margin-top: 10px;
        }

        .main-div .tr-first .center-text {
            font-size: 11px;
            text-align: center !important;
        }

        .footer-div {
            font-size: 11px;
            font-weight: bold;
            width: 100%;
        }

        .footer-div .tr-first .center-text {
            font-size: 11px;
            text-align: center !important;
        }

        .footer-div table td,
        .footer-div table tr {
            border: none;
        }

        .center-text {
            text-align: center !important;
        }

        .font-12 {
            font-size: 12px !important;
        }

        .font-15 {
            font-size: 15px !important;
        }

        .font-20 {
            font-size: 20px !important;
        }

        .w-20 {
            width: 31%;
        }

        .w-50 {
            width: 55%;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 30px;
        }

        .tr-header {
            height: 150px;
            background-color: #dddddd;
        }

        .tr-body {
            height: 40px;
        }

        .tr-sub-header {
            height: 16px !important;
            background-color: darkgrey;
        }

        .w-25 {
            width: 25%;
        }

        .mt-40 {
            margin-top: 40px;
        }
        .new-padding {
            padding-top:0px !important;
            padding-bottom:0px !important;
        }
    </style>
</head>

<body>
    <div id="container">
        <div class="second-div">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td class="bLeft font-15 w-20">
                        <h6>CÔNG TY CỔ PHẦN BÌNH ĐIỀN</h6>
                    </td>
                    <td class="center-text font-20 w-50">
                        <h3>PHIẾU XUẤT KHO</h3>
                    </td>
                    <td class="center-text font-12">SPX: {{ $order->id }}</td>
                </tr>
            </table>
        </div>

        <div class="second-div">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td class="center-text font-15">Số: {{ $order->order_code }}</td>
                </tr>
                <tr>
                    <td class="center-text font-12">Ngày: {{ $order->delivery_date->format('d') }} tháng
                        {{ $order->delivery_date->format('m') }} năm
                        {{ $order->delivery_date->format('Y') }} </td>
                </tr>
            </table>
        </div>

        <div class="second-div mt-10">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td class="bLeft new-padding">Đơn vị nhận hàng:</td>
                    <td class="middle new-padding" colspan="2">{{ $order->customer->name }}</td>
                </tr>
                <tr>
                    <td class="bLeft new-padding">Theo chứng từ:</td>
                    <td class="middle new-padding" colspan="2"><strong>{{ $order->document }}</strong></td>
                </tr>
                <tr>
                    <td class="bLeft new-padding">Xuất tại kho:</td>
                    <td class="middle new-padding">{{ $order->storage->name }}</td>
                    <td class="middle new-padding">Địa chỉ: {{ $order->storage->address }}</td>
                </tr>
                <tr>
                    <td class="bLeft new-padding">Thông tin giao nhận:</td>
                    <td class="middle new-padding">{{ $order->receive_info }}</td>
                    <td class="middle new-padding">Xe/Cont: {{ $order->receive_cont }}</td>
                </tr>
            </table>
        </div>
        <div class="main-div">
            <table cellspacing="0" cellpadding="0">
                <tr class="tr-first tr-header">
                    <td class="center-text">STT</td>
                    <td class="center-text">Tên sản phẩm hàng hóa</td>
                    <td class="center-text">Qui cách đóng gói/kg</td>
                    <td class="center-text">Đơn vị tính</td>
                    <td class="center-text">Lô Hàng</td>
                    <td class="center-text">Hạn sử dụng</td>
                    <td class="center-text">Khối lượng (kg)</td>
                    <td class="center-text">Số lượng</td>
                    <td class="center-text">Ghi chú</td>
                </tr>
                <tr class="tr-first tr-sub-header" style="font-size: 11px">
                    <td class="center-text">A</td>
                    <td class="center-text">B</td>
                    <td class="center-text">C</td>
                    <td class="center-text">D</td>
                    <td class="center-text">E</td>
                    <td class="center-text">F</td>
                    <td class="center-text">G</td>
                    <td class="center-text">H</td>
                    <td class="center-text">I</td>
                </tr>
                 @if ($order->order_detail)
                    <?php $num = 1; ?>
                    <?php $totalArrQuantity = []; ?>
                    <?php $totalKg = []; ?>
                    @foreach ($order->order_detail as $value)
                        <tr class="tr-first tr-body" style="font-size: 11px">
                            <td class="center-text">{{ $num }}</td>
                            <td class="center-text">{{ $value->product->name }}</td>
                            <td class="center-text">{{ $value->product->specification }}</td>
                            <td class="center-text">{{ $value->product->unit }}</td>
                            <td class="center-text">
                                {{ $order->delivery_date ? $order->delivery_date->format('dmY') : '' }}
                            </td>
                            <td class="center-text"></td>
                            <?php $kg = $value->quantity && $value->product->specification && is_numeric($value->product->specification) ? $value->quantity * $value->product->specification : 0; ?>
                            <td class="center-text">
                                {{ $kg }}
                            </td>
                            <td class="center-text">{{ $value->quantity }}</td>
                            <td class="center-text"></td>
                        </tr>
                        <?php array_push($totalKg, $kg); ?>
                        <?php array_push($totalArrQuantity, $value->quantity); ?>
                        <?php $num++; ?>
                    @endforeach
                    <tr class="tr-first" style="font-size: 11px">
                        <td class="center-text"></td>
                        <td class="center-text"><strong>Cộng:</strong></td>
                        <td class="center-text"></td>
                        <td class="center-text"></td>
                        <td class="center-text"></td>
                        <td class="center-text"></td>
                        <td class="center-text">{{ array_sum($totalKg) }}</td>
                        <td class="center-text">{{ array_sum($totalArrQuantity) }}</td>
                        <td class="center-text"></td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="footer-div mt-20">
            <table cellspacing="0" cellpadding="0">
                <tr class="tr-first">
                    <td class="center-text w-25">Người Lập Phiếu</td>
                    <td class="center-text w-25">Bộ phận giao nhận</td>
                    <td class="center-text w-25">Thủ Kho Hàng</td>
                    <td class="center-text w-25">Phụ trách Tổ KD</td>
                </tr>
            </table>
        </div>

        <div class="footer-div mt-40">
            <table cellspacing="0" cellpadding="0">
                <tr class="tr-first">
                    <td class="center-text w-25">{{ Auth::user()->name }}</td>
                    <td class="center-text w-25">
                        {{ $order->receive_user ? $order->receiveUser->name : '' }}
                    </td>
                    <td class="center-text w-25">
                        {{ $order->wh_user ? $order->whUser->name : '' }}</td>
                    <td class="center-text w-25">
                        {{ $order->sales_user ? $order->saleUser->name : '' }}</td>
                </tr>
            </table>
        </div>

        <div class="footer-div mt-20">
            <table cellspacing="0" cellpadding="0">
                <tr class="tr-first">
                    <td class="center-text w-25">Người nhận hàng</td>
                    <td class="center-text w-25"></td>
                    <td class="center-text w-25"></td>
                    <td class="center-text w-25"></td>
                </tr>
            </table>
        </div>

        <div class="footer-div mt-40">
            <table cellspacing="0" cellpadding="0">
                <tr class="tr-first">
                    <td class="center-text w-25">{{ $order->customer_id ? $order->customer->name : '' }}</td>
                    <td class="center-text w-25">
                        
                    </td>
                    <td class="center-text w-25">
                        </td>
                    <td class="center-text w-25">
                        </td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>
