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
                    if(count($priceInfo->price_customer) > 0) {
                        $price = $priceInfo->price_customer[0]['price'];
                    }else {
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
  }