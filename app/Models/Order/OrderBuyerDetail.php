<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBuyerDetail extends Model
{
    use HasFactory;
    protected $table = 'ord_buyer_details';

    protected $fillable = [
        'order_id', 'input_content', 'description', 'created_by'
    ];
}
