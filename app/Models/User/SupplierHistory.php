<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class SupplierHistory extends Model
{
    use HasFactory;
    protected $table = 'supplier_histories';
    protected $fillable = [
        'supplier_id','name', 'address', 'tax_code', 'supplier_code', 'updated_by', 'created_by', 'contract_signing_date'
    ];

    public function user_updated()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function user_created()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
