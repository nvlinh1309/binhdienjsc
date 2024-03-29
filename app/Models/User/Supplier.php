<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'suppliers';
    protected $casts = [
        'contract_signing_date' => 'datetime',
      ];
    protected $fillable = [
        'supplier_code','name', 'address', 'tax_code','contract_signing_date'
    ];
}
