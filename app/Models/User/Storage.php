<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User\Product;

class Storage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'storages';

    protected $fillable = [
        'name', 'address', 'code'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'storage_product', 'product_id', 'storage_id');
    }

}
