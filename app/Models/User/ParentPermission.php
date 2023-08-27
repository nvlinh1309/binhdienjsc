<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class ParentPermission extends Model
{
    use HasFactory;
    protected $table = 'parent_permission';
    
    protected $fillable = [
        'parent_name'
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'parent_id', 'id');
    }


}
