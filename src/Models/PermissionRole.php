<?php

namespace Doc88\FluxRolePermission\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model {
    protected $table = 'permissions_roles';
    public $guarded = ['id'];

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
