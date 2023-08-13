<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\User\OrderDetail;
class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'orders';

    protected $casts = [
        'delivery_date' => 'datetime',
      ];

    protected $fillable = [
        'order_code', 'customer_id', 'payment_method', 'document', 'storage_id', 'receive_info', 'receive_cont', 'delivery_date', 'receive_user',
        'wh_user', 'sales_user', 'order_status'
    ];

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    // public function customer()
    // {
    //     return $this->has('App\User\Customer');
    // }
    public function approvalUser()
    {
        return $this->belongsTo(User::class, 'approval_user', 'id');
    }

    public function receiveUser()
    {
        return $this->belongsTo(User::class, 'receive_user', 'id');
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class, 'storage_id', 'id');
    }
    public function whUser()
    {
        return $this->belongsTo(User::class, 'wh_user', 'id');
    }

    public function saleUser()
    {
        return $this->belongsTo(User::class, 'sales_user', 'id');
    }
}
