<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\Product;
use App\Models\User\PriceCustomerProdManagement;

class ProductGoodsReceiptManagement extends Model
{
    use HasFactory;
    protected $table = 'product_goods_receipt_management';

    protected $fillable = [
        'goods_receipt_id', 'product_id', 'quantity', 'date_of_manufacture', 'expiry_date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function prices()
    {
        return $this->hasMany(PriceCustomerProdManagement::class, 'product_goods_id', 'id');
    }
}
