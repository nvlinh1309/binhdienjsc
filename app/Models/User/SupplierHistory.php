<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierHistory extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $fillable = [
        'supplier_id','content'
    ];
}
