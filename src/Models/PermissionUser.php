<?php

namespace Doc88\FluxRolePermission\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model {
    protected $table = 'permissions_users';
    public $guarded = ['id'];

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
