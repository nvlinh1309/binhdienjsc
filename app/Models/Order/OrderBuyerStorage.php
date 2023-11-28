<?php

namespace App\Models\Order;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBuyerStorage extends Model
{
    use HasFactory;
    protected $table = 'ord_buyer_storage';
    protected $casts = [
        'input_date' => 'datetime',
      ];

    protected $fillable = [
        'order_id', 'spn_number', 'code', 'input_date','content','cont','warehouse_staff_id'
    ];

    public function warehouse_staff()
    {
        return $this->belongsTo(User::class, 'warehouse_staff_id', 'id');
    }


}
