<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'orders';

    protected $fillable = [
        'order_code', 'customer_id', 'payment_method'
    ];

    public function order_detail()
    {
        return $this->hasMany('App\User\OrderDetail', 'order_id', 'id');
    }

    // public function customer()
    // {
    //     return $this->has('App\User\Customer');
    // }
}
