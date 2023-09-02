<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageProduct extends Model
{
    use HasFactory;
    protected $table = 'storage_product';
    protected $fillable = [
        'storage_id', 'product_id', 'quantity_plus', 'quantity_mins','in_stock','sold','order_buyer_id','product_info'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function orderBuyer()
    {
        return $this->belongsTo(Orde::class, 'product_id', 'id');
    }

}
