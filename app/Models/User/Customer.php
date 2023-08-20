<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'customers';

    protected $casts = [
        'contact' => 'array'
    ];
    protected $fillable = [
        'name', 'code', 'tax_code', 'address', 'contact', 'tax'
    ];
    public function product_price()
    {
        return $this->hasMany(PriceCustomerProdManagement::class, 'customer_id', 'id');
    }

}
