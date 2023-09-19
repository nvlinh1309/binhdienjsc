<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\Packaging;
use App\Models\User\Storage;

class PackagingStorage extends Model
{
    use HasFactory;

    protected $table = 'packaging_storage';

    protected $fillable = [
        'packaging_id', 'storage_id', 'quantity', 'lot', 'in_stock','contract_quantity','note', 'status'
    ];


    public function packaging()
    {
        return $this->belongsTo(Packaging::class, 'packaging_id', 'id');
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class, 'storage_id', 'id');
    }
}
