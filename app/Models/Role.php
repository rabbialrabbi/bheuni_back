<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    /**
     * Many-To-Many Relationship Method for accessing the Role->permissions
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    /**
     * Assign permission to certain roles
     */
    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->syncWithoutDetaching($permission);
    }
}
