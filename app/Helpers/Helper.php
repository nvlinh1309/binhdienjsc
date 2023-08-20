<?php
use App\Models\User\GoodsReceiptManagement;
use App\Models\User\Product;
use App\Models\User\Storage;

if (!function_exists('aFunctionName')) {
    function getProductBasedWhHelper($whId, $customerId)
    {
        $data = Storage::with('storage_product', 'storage_product.product')->find($whId);
        $listProd = [];
        if ($data) {
            $temp = $data->toArray();
            foreach ($temp['storage_product'] as $no => $detail) {
                $quantityReal = $detail['quantity_plus'] - $detail['quantity_mins'];
                if ($quantityReal > 0) {
                    // Get price 
                    $priceInfo = Product::with([
                        'price_customer' => function ($query) use ($detail, $customerId) {
                            $query->with('customer')->where(array('product_id' => $detail['product_id'], 'customer_id' => $customerId))->first();
                        }
                    ])->find($detail['product_id']);
                    if (count($priceInfo->price_customer) > 0) {
                        $price = $priceInfo->price_customer[0]['price'];
                    } else {
                        $price = 0;
                    }
                    $listProd[$detail['product_id']] = array(
                        'real_quantity' => $quantityReal,
                        'price' => $price,
                        'name' => $detail['product']['name']
                    );
                }
            }
            ksort($listProd);
        }
        return $listProd;
    }

    function numInWords($num)
    {
        $nwords = array(
            0 => 'không',
            1 => 'một',
            2 => 'hai',
            3 => 'ba',
            4 => 'bốn',
            5 => 'năm',
            6 => 'sáu',
            7 => 'bảy',
            8 => 'tám',
            9 => 'chín',
            10 => 'mười',
            11 => 'mười một',
            12 => 'mười hai',
            13 => 'mười ba',
            14 => 'mười bốn',
            15 => 'mười lăm',
            16 => 'mười sáu',
            17 => 'mười bảy',
            18 => 'mười tám',
            19 => 'mười chín',
            20 => 'hai mươi',
            30 => 'ba mươi',
            40 => 'bốn mươi',
            50 => 'năm mươi',
            60 => 'sáu mươi',
            70 => 'bảy mươi',
            80 => 'tám mươi',
            90 => 'chín mươi',
            100 => 'trăm',
            1000 => 'nghìn',
            1000000 => 'triệu',
            1000000000 => 'tỷ',
            1000000000000 => 'nghìn tỷ',
            1000000000000000 => 'ngàn triệu triệu',
            1000000000000000000 => 'tỷ tỷ',
        );
        $separate = ' ';
        $negative = ' âm ';
        $rltTen = ' linh ';
        $decimal = ' phẩy ';
        if (!is_numeric($num)) {
            $w = '#';
        } else if ($num < 0) {
            $w = $negative . numInWords(abs($num));
        } else {
            if (fmod($num, 1) != 0) {
                $numInstr = strval($num);
                $numInstrArr = explode(".", $numInstr);
                $w = numInWords(intval($numInstrArr[0])) . $decimal . numInWords(intval($numInstrArr[1]));
            } else {
                $w = '';
                if ($num < 21) // 0 to 20
                {
                    $w .= $nwords[$num];
                } else if ($num < 100) {
                    // 21 to 99
                    $w .= $nwords[10 * floor($num / 10)];
                    $r = fmod($num, 10);
                    if ($r > 0) {
                        $w .= $separate . $nwords[$r];
                    }

                } else if ($num < 1000) {
                    // 100 to 999
                    $w .= $nwords[floor($num / 100)] . $separate . $nwords[100];
                    $r = fmod($num, 100);
                    if ($r > 0) {
                        if ($r < 10) {
                            $w .= $rltTen . $separate . numInWords($r);
                        } else {
                            $w .= $separate . numInWords($r);
                        }
                    }
                } else {
                    $baseUnit = pow(1000, floor(log($num, 1000)));
                    $numBaseUnits = (int) ($num / $baseUnit);
                    $r = fmod($num, $baseUnit);
                    if ($r == 0) {
                        $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit];
                    } else {
                        if ($r < 100) {
                            if ($r >= 10) {
                                $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . ' không trăm ' . numInWords($r);
                            } else {
                                $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . ' không trăm linh ' . numInWords($r);
                            }
                        } else {
                            $baseUnitInstr = strval($baseUnit);
                            $rInstr = strval($r);
                            $lenOfBaseUnitInstr = strlen($baseUnitInstr);
                            $lenOfRInstr = strlen($rInstr);
                            if (($lenOfBaseUnitInstr - 1) != $lenOfRInstr) {
                                $numberOfZero = $lenOfBaseUnitInstr - $lenOfRInstr - 1;
                                if ($numberOfZero == 2) {
                                    $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . ' không trăm linh ' . numInWords($r);
                                } else if ($numberOfZero == 1) {
                                    $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . ' không trăm ' . numInWords($r);
                                } else {
                                    $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . $separate . numInWords($r);
                                }
                            } else {
                                $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . $separate . numInWords($r);
                            }
                        }
                    }
                }
            }
        }
        return $w;
    }

    function numberInVietnameseWords($num)
    {
        return str_replace("mươi năm", "mươi lăm", str_replace("mươi một", "mươi mốt", numInWords($num)));
    }

    function numberInVietnameseCurrency($num)
    {
        $rs = numberInVietnameseWords($num);
        $rs[0] = strtoupper($rs[0]);
        return $rs . ' đồng';
    }
}