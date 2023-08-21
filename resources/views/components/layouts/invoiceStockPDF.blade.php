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
            width: 50%;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 15px;
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
            padding-top: 2px !important;
            padding-bottom: 0px !important;
        }

        .text-nowrap {
            text-align: center;
        }

        .font-11 {
            font-size: 12px !important;
        }

        .mb-2 {
            margin-bottom: 2px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .mt-0 {
            margin-top: 0px;
        }

        .mb-0 {
            margin-bottom: 0px;
        }

        .mt-2 {
            margin-top: 2px;
        }

        .text-right {
            text-align: right;
        }

        .line-bottom {
            text-align: center;
            display: inline-block;
            border-bottom: 1px solid black;
        }
    </style>
</head>

<body>
    <div id="container">
        <div class="second-div">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td class="bLeft font-15 w-50" style="text-align: center">
                        <h5>CÔNG TY CỔ PHẦN BÌNH ĐIỀN</h5>
                    </td>
                    <td class="center-text font-15 w-50">
                        <h5 class="mb-0">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h5>
                        <span class="font-11"><strong>Độc lập - Tự do - Hạnh phúc</strong></span><br />
                    </td>
                </tr>
            </table>
        </div>
        <div class="second-div">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td class="bLeft font-15 w-50" style="text-align: center">
                        <h5></h5>
                    </td>
                    <td class="center-text font-15 w-50">
                        <p class="font-11 mb-0 mt-0">TP Hồ Chí Minh, ngày {{ date('d') }} tháng {{ date('m') }}
                            năm {{ date('Y') }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="second-div text-nowrap border-t">
            <p class="mb-2"><strong>ĐƠN ĐẶT HÀNG</strong></p>
            <p class="mt-0"><strong>Số: 03/2023/DH-BD</strong></p>
        </div>
        <div class="second-div text-nowrap border-t font-11">
            <p class="mb-2 mt-0">Kính gửi: <strong>{{ $goodReceiptManagement->supplier->name }}</strong></p>
            <p class="mt-0">Địa chỉ: {{ $goodReceiptManagement->supplier->address }}</p>
        </div>
        <div class="second-div">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td class="bLeft new-padding" style="font-size: 11px">Đơn vị mua hàng:</td>
                    <td class="middle new-padding" style="font-size: 11px">Công ty CP Bình Điền</td>
                </tr>
                <tr>
                    <td class="new-padding" style="font-size: 11px">Địa chỉ:</td>
                    <td class="middle new-padding" style="font-size: 11px"><strong>74 Đường số 2, cư xá Đô Thành, Phường
                            4, Quận 3,
                            Tp.HCM</strong></td>
                </tr>
                <tr>
                    <td class="new-padding" style="font-size: 11px">Mã số thuế:</td>
                    <td class="middle new-padding" style="font-size: 11px">0304866778</td>
                </tr>
            </table>
        </div>
        <div class="footer-div mt-2">
            <p>Nội dung đơn hàng:</p>
            <p><strong>1. MẶT HÀNG - SỐ LƯỢNG - ĐƠN GIÁ:</strong></p>
        </div>
        <div class="main-div">
            <table cellspacing="0" cellpadding="0">
                <tr class="tr-first tr-header">
                    <td class="center-text">STT</td>
                    <td class="center-text" style="width: 30%">MẶT HÀNG</td>
                    <td class="center-text">Qui cách bao bì</td>
                    <td class="center-text">SỐ LƯỢNG (KG)</td>
                    <td class="center-text">ĐƠN GIÁ (vnđ/kg)</td>
                    <td class="center-text">THÀNH TIỀN (vnđ)</td>
                    <td class="center-text">GHI CHÚ</td>
                </tr>
                @if ($goodReceiptManagement->productGood)
                    <?php $num = 1; ?>
                    <?php $totalPrice = []; ?>
                    <?php $totalKg = []; ?>
                    @foreach ($goodReceiptManagement->productGood as $value)
                        <tr class="tr-first" style="font-size: 11px">
                            <td class="center-text">{{$num}}</td>
                            <td class="center-text">{{ $value->product->name }}</td>
                            <td class="center-text">{{ $value->product->specification }}</td>
                            <td class="center-text">{{$value->quantity}}</td>
                            <td class="center-text">{{ number_format($value->product->price, 0, ',', '.')}}</td>
                            <td class="center-text">{{ number_format($value->quantity * $value->product->price, 0, ',', '.') }}</td>
                            <td class="center-text">{{$value->note_product}}</td>
                        </tr>
                        <?php array_push($totalKg, $value->quantity); ?>
                        <?php array_push($totalPrice, $value->quantity * $value->product->price) ?>
                        <?php $num++; ?>
                    @endforeach
                @endif
                <tr class="tr-first" style="font-size: 11px">
                    <td class="center-text" colspan="3"><strong>Tổng cộng:</strong></td>
                    <td class="center-text"><strong>{{ array_sum($totalKg) }}</strong></td>
                    <td class="center-text"></td>
                    <td class="center-text"><strong>{{ number_format(array_sum($totalPrice), 0, ',', '.') }}</strong></td>
                    <td class="center-text"></td>
                </tr>
            </table>
        </div>
        <div class="footer-div mt-0">
            <span><strong>Bằng chữ:</strong> <?php echo numberInVietnameseCurrency(array_sum($totalPrice)) ?>./.</span> <br />
            <span>Đơn giá trên chưa bao gồm phí vận chuyển nếu nhận hàng tại kho Bình Điền.</span><br />
            <span>- Giá trên được căn cứ vào Hợp đồng số 23-2022/BD-NQP ngày 01 tháng 12 năm 2022</span>
        </div>
        <div class="footer-div mt-2">
            <span><strong>2. KẾ HOẠCH VÀ NƠI NHẬN HÀNG:</strong></span><br />
            <span>- Thời gian dự kiến giao hàng: Trong tháng 02/2023</span><br />
            <span>Rất mong Quý Công ty xem xét và trả lời sớm.</span>
        </div>
        <div class="footer-div mt-2">
            <p>Trân trọng./.</p>
        </div>
        <div class="footer-div mt-20">
            <table cellspacing="0" cellpadding="0">
                <tr class="tr-first">
                    <td class="center-text w-25"></td>
                    <td class="center-text w-25"></td>
                    <td class="center-text w-25"></td>
                    <td class="center-text w-25">ĐƠN VỊ ĐẶT HÀNG</td>
                </tr>
            </table>
        </div>

        <div class="footer-div mt-40">
            <table cellspacing="0" cellpadding="0">
                <tr class="tr-first">
                    <td class="center-text w-25"></td>
                    <td class="center-text w-25">

                    </td>
                    <td class="center-text w-25">
                    </td>
                    <td class="center-text w-25">
                        {{ $goodReceiptManagement->sales_user ? $goodReceiptManagement->saleUser->name : '' }} </td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>
