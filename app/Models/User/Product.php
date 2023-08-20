<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User\Brand;
use App\Models\User\PriceCustomerProdManagement;


class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'products';

    protected $fillable = [
        'name', 'brand_id', 'barcode', 'specification', 'unit', 'price'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function price_customer()
    {
        return $this->hasMany(PriceCustomerProdManagement::class, 'product_id', 'id');
    }
}
