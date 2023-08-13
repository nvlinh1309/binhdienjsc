<?php
use App\Models\User\GoodsReceiptManagement;
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
                    $price = GoodsReceiptManagement::with([
                        'productGood' => function ($query) use ($detail, $customerId) {
                            $query->with([
                                'prices' => function ($query) use ($customerId) {
                                    $query->where('customer_id', '=', $customerId)->first();
                                }
                            ])
                                ->where('product_id', '=', $detail['product_id'])->first();
                        }
                    ])->where(array('storage_id' => $whId, 'receipt_status' => 3))->whereRelation('productGood', 'product_id', $detail['product_id'])->get();
                    if ($price) {
                        $temp = $price->toArray();
                        $price = $temp[0]['product_good'][0]['prices'][0]['price'];
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