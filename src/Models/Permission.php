<?php

namespace Doc88\FluxRolePermission\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
    protected $table = 'permissions';
    public $guarded = ['id'];
}
