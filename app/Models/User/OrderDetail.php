<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OrderDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'order_detail';

    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price'
    ];

}
