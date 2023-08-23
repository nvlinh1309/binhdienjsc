<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class BrandHistory extends Model
{
    use HasFactory;
    protected $table = 'brands_history';
    public function user_updated()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function user_created()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
