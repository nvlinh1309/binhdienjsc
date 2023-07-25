<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\Customer;

class PriceCustomerProdManagement extends Model
{
    use HasFactory;
    protected $table = 'price_customer_prod_management';
    
    protected $fillable = [
        'product_goods_id', 'customer_id', 'price'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
