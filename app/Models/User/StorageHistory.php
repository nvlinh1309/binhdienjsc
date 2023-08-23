<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class StorageHistory extends Model
{
    use HasFactory;
    protected $table = 'storages_history';
    protected $fillable = [
        'storage_id', 'name', 'address', 'code', 'updated_by', 'created_by'
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
