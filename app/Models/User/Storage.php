<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User\Product;
use App\Models\User\StorageProduct;

class Storage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'storages';

    protected $fillable = [
        'name', 'address', 'code'
    ];

    // public function storage_product()
    // {
    //     return $this->belongsToMany(Product::class, 'storage_product', 'storage_id', 'product_id');
    // }
    public function storage_product()
    {
        return $this->hasMany(StorageProduct::class, 'storage_id', 'id');
    }

}
