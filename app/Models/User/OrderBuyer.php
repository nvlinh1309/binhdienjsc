<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;


class OrderBuyer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'order_buyer';

    protected $fillable = [
        'code', 'order_info', 'products', 'warehouse_recript', 'supplier_id', 'storage_id','status', 'assignee','created_by', 'order_approver'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
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

}
