<?php

namespace App\Models\Order;

use App\Models\User;
use App\Models\User\Storage;
use App\Models\User\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OrderBuyer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'ord_buyers';

    // protected $casts = [
    //     'delivery_date' => 'datetime',
    //   ];

    protected $fillable = [
        'code', 'supplier_id', 'storage_id', 'company_name', 'company_address', 'company_tax', 'estimated_delivery_time', 'status', 'approved_by', 'created_by', 'order_file'
    ];

    public function order_detail()
    {
        return $this->hasMany(OrderBuyerDetail::class, 'order_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(OrderBuyerProduct::class, 'order_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class, 'storage_id', 'id');
    }

    public function storage_info()
    {
        return $this->hasOne(OrderBuyerStorage::class, 'order_id', 'id');
    }

}
