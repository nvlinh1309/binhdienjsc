<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\PackagingStorage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Packaging extends Model
{
    use HasFactory;

    protected $table = 'packaging';

    protected $fillable = [
        'name',
    ];

    public function getDetail(): HasMany
    {
        return $this->hasMany(PackagingStorage::class)->orderBy('id', 'desc');
    }
}
