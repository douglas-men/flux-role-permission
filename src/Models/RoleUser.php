<?php

namespace Doc88\FluxRolePermission\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model {
    protected $table = 'roles_users';
    public $guarded = ['id'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
