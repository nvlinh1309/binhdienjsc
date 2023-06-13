<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User\Supplier;


class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'brands';
    protected $fillable = [
        'name'
    ];

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'brand_supplier', 'brand_id', 'supplier_id');
    }

}
