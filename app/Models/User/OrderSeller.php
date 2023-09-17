<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrderSeller extends Model
{
    use HasFactory;

    protected $table = 'order_seller';

    protected $fillable = [
        'customer_id', 'to_deliver_code', 'to_deliver_date', 'storage_id', 'to_deliver_info', 'to_deliver_transport','products', 'status','assignee', 'order_approver', 'created_by','warehouse_keeper'
    ];

    protected $casts = [
        'products' => 'json',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class, 'storage_id', 'id');
    }

    public function user_assignee()
    {
        return $this->belongsTo(User::class, 'assignee', 'id');
    }

    public function user_order_approver()
    {
        return $this->belongsTo(User::class, 'order_approver', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function warehouseKeeper()
    {
        return $this->belongsTo(User::class, 'warehouse_keeper', 'id');
    }

}
