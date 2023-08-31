<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OrderBuyer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'order_buyer';

    protected $fillable = [
        'code', 'order_info', 'products', 'warehouse_recript', 'supplier_id', 'storage_id','status'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class, 'storage_id', 'id');
    }

}
