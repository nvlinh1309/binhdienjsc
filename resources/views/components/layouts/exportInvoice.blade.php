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

        .text-nowrap {
            text-align: center;
        }

        .border-t {
            {{-- border: 1px solid black; --}}
        }

        .w-20 {
            width: 170px;
        }

        .line-bottom {
            text-align: center;
            display: inline-block;
            border-bottom: 1px solid black;
        }

        .mb-0 {
            margin-bottom: 0px !important;
        }

        .block-inline {
            display: inline-table !important;
            text-align: left;
            width: 420px;
        }

        .w-590 {
            width: 480px;
        }

        .mb-20 {
            margin-bottom: 16px !important;
        }

        .font-11 {
            font-size: 12px !important;
        }

        .mb-2 {
            margin-bottom: 5px
        }

        .mb-10 {
            margin-bottom: 10px
        }

        .w-25 {
            width: 25%;
        }

        .w-30 {
            width: 30%;
        }

        .w-20 {
            width: 20%;
        }

        .mt-40 {
            margin-top: 40px;
        }

        .footer-div table td,
        .footer-div table tr {
            border: none;
        }

        .footer-div .tr-first .center-text {
            font-size: 11px;
            text-align: center !important;
        }
    </style>
</head>

<body>
    <div id="container">
        <div class="second-div text-nowrap border-t">
            <p class="mb-2"><strong>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong></p>
            <p class="mb-0" style="margin-top: 5px"><strong>Độc lập - Tự do - Hạnh phúc</strong></p>
            <div class="border-t w-20 line-bottom">
            </div>
        </div>
        <div class="second-div text-nowrap border-t">
            <p class="mb-20"><strong>GIẤY ĐỀ NGHỊ XUẤT HÓA ĐƠN</strong></p>
        </div>
        <div class="second-div text-nowrap border-t font-11">
            <p><strong><u>Kính gửi</u>: Phòng Tài Chính Kế Toán - Công ty cổ phần Bình Điền</strong></p>
        </div>
        <div class="second-div text-nowrap border-t mb-20 font-11">
            <div class="block-inline">
                <li style="list-style-type: none">-&nbsp;&nbsp;&nbsp;&nbsp;Căn cứ Hợp đồng nguyên tắc số: 04/HĐNT/2022
                    ngày 03 tháng 01 năm 2023 giữa Công ty cổ phần Bình Điền và {{ $order->customer->name }}
                </li>
            </div>
        </div>
        <div class="second-div text-nowrap border-t mb-10 font-11">
            <div class="block-inline w-590">
                <span>Tổ Kinh Doanh Gạo - Công ty cổ phần Bình Điền làm giấy đề nghị xuất hóa đơn cho đơn hàng xuất kho
                    ngày 03 tháng 02 năm 2023 với thông tin như sau:</span>
            </div>
        </div>
        <div class="second-div text-nowrap border-t mb-20 font-11">
            <div class="block-inline">
                <li class="font-11" style="list-style-type: none">*&nbsp;&nbsp;&nbsp;&nbsp;<u>Thông tin xuất hóa
                        đơn:</u></li>
                <li class="font-11" style="list-style-type: none">-&nbsp;&nbsp;&nbsp;&nbsp;Tên Công ty:
                    <strong>{{ $order->customer->name }}</strong></li>
                <li class="font-11" style="list-style-type: none">-&nbsp;&nbsp;&nbsp;&nbsp;Địa chỉ:
                    <span>{{ $order->customer->address }}</span></li>
                <li class="font-11" style="list-style-type: none">-&nbsp;&nbsp;&nbsp;&nbsp;Mã số thuế:
                    <span>{{ $order->customer->tax_code }}</span></li>
                <li class="font-11" style="list-style-type: none">-&nbsp;&nbsp;&nbsp;&nbsp;Ngày xuất hóa đơn:
                    <span><strong>{{ date('d/m/Y') }}</strong></span></li>
            </div>
        </div>

        <div class="main-div">
            <table cellspacing="0" cellpadding="0">
                <tr class="tr-first tr-header">
                    <td rowspan="2" class="center-text font-11" clos><strong>59</strong></td>
                    <td rowspan="2" class="center-text font-11"><strong>Nội dung</strong></td>
                    <td rowspan="2" class="center-text font-11"><strong>Thương hiệu</strong></td>
                    <td rowspan="2" class="center-text font-11"><strong>Lô nhập</strong></td>
                    <td class="center-text font-11" colspan="3"><strong>Quy cách đóng gói</strong></td>
                    <td rowspan="2" class="center-text font-11"><strong>Số lượng bao</strong></td>
                    <td rowspan="2" class="center-text font-11"><strong>Đơn giá bao</strong></td>
                    <td rowspan="2" class="center-text font-11"><strong>Thành tiền (VNĐ)</strong></td>
                </tr>
                <tr class="tr-first tr-sub-header" style="font-size: 11px">
                    <td class="center-text font-11"><strong>5kg</strong></td>
                    <td class="center-text font-11"><strong>10kg</strong></td>
                    <td class="center-text font-11"><strong>25kg</strong></td>
                </tr>
                <?php 
                $num = 1;
                $total = 0;
                ?>
                @if (count($order->order_detail) > 0)
                    @foreach ($order->order_detail as $detailProduct)
                        <tr class="tr-first" style="font-size: 11px">
                            <td class="center-text">{{$num}}</td>
                            <td class="center-text"><strong>{{$detailProduct->product->name}}</strong></td>
                            <td class="center-text">{{$detailProduct->product->brand->name}}</td>
                            <td class="center-text">{{ $order->delivery_date ? $order->delivery_date->format('d.m.Y') : '' }}</td>
                            <td class="center-text">{{ $detailProduct->product->specification == 1 ? "X": "" }}</td>
                            <td class="center-text">{{ $detailProduct->product->specification == 2 ? "X": "" }}</td>
                            <td class="center-text">{{ $detailProduct->product->specification == 3 ? "X": "" }}</td>
                            <td class="center-text">{{ $detailProduct->quantity }}</td>
                            <td class="center-text">{{ number_format($detailProduct->price, 0, ',', '.') }}</td>
                            <td class="center-text">{{ number_format($detailProduct->price*$detailProduct->quantity, 0, ',', '.') }}</td>
                        </tr>
                        <?php 
                        $num++;
                        $total = $total + ($detailProduct->price*$detailProduct->quantity);
                        ?>
                    @endforeach
                    
                @endif
                <tr class="tr-first" style="font-size: 11px">
                    <td colspan="4" class="center-text"><strong>Tổng</strong></td>
                    <td class="center-text"></td>
                    <td class="center-text"></td>
                    <td class="center-text"></td>
                    <td class="center-text"></td>
                    <td class="center-text"></td>
                    <td class="center-text"><strong>{{ number_format($total, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>
        <p class="font-11" style="text-align: right;padding-right: 15px">Tổng giá trị hóa đơn số tiền: {{ number_format($total, 0, ',', '.') }} đ (<?php echo numberInVietnameseCurrency($total) ?>./.)</p>

        <div class="second-div text-nowrap border-t mb-20 font-11">
            <div class="block-inline">
                <li style="list-style-type: none">-&nbsp;&nbsp;&nbsp;&nbsp;<u>Địa chỉ nhận hóa đơn điện
                        tử</u><strong>:trucnguyenho@gmail.com</strong></li>
            </div>
        </div>

        <div class="footer-div mt-20">
            <table cellspacing="0" cellpadding="0">
                <tr class="tr-first">
                    <td class="center-text w-25"></td>
                    <td class="center-text w-25"></td>
                    <td class="center-text w-20"></td>
                    <td class="center-text w-30" style="font-size: 9px;"><strong>TỔ TRƯỞNG TỔ KINH DOANH GẠO</strong>
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer-div mt-40">
            <table cellspacing="0" cellpadding="0">
                <tr class="tr-first">
                    <td class="center-text w-25"></td>
                    <td class="center-text w-25"></td>
                    <td class="center-text w-20"></td>
                    <td class="center-text w-30" style="font-size: 9px;"><strong>NGUYỄN THỊ THANH HẰNG</strong></td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>
