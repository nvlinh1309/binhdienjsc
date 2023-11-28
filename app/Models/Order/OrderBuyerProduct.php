<?php

namespace App\Models\Order;

use App\Models\User\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBuyerProduct extends Model
{
    use HasFactory;
    protected $table = 'ord_buyer_products';
    protected $casts = [
        'product_mfg' => 'datetime',
        'product_exp' => 'datetime',
      ];

    protected $fillable = [
        'order_id', 'product_id', 'product_price', 'product_quantity','product_mfg','product_exp','product_note'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

