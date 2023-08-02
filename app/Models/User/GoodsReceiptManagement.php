<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\Supplier;
use App\Models\User\Storage;
use App\Models\User\ProductGoodsReceiptManagement;
use App\Models\User;

class GoodsReceiptManagement extends Model
{
    use HasFactory;
    protected $table = 'goods_receipt_management';

    protected $fillable = [
        'goods_receipt_code', 'supplier_id', 'document', 'storage_id', 'unit', 'receipt_date'
    ];

    protected $casts = [
        'receipt_date' => 'datetime',
      ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class, 'storage_id', 'id');
    }

    public function productGood()
    {
        return $this->hasMany(ProductGoodsReceiptManagement::class, 'goods_receipt_id', 'id');
    }

    public function approvalUser()
    {
        return $this->belongsTo(User::class, 'approval_user', 'id');
    }

    public function receiveUser()
    {
        return $this->belongsTo(User::class, 'receive_user', 'id');
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
