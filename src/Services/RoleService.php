<?php

namespace Doc88\FluxRolePermission\Services;

use Doc88\FluxRolePermission\Models\PermissionUser;
use Doc88\FluxRolePermission\Models\Role;
use Doc88\FluxRolePermission\Models\RoleUser;

class RoleService {

    protected $user;
    protected $role;

    public function __construct($user, $role = null)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Lista as roles
     */
    public function listRoles()
    {
        if (AdminService::checkIfIsAdmin($this->user)) {
            $response = Role::get()->transform(function ($item) {
                return [
                    'id'   => $item->id,
                    'name' => $item->name,
                    'slug' => $item->slug
                ];
            });
        } else {
            $response = RoleUser::with('role')
                ->whereUserId($this->user->id)
                ->get()
                ->transform(function ($item) {
                    if (!empty($item->role)) {
                        return [
                            'id'   => $item->role->id,
                            'name' => $item->role->name,
                            'slug' => $item->role->slug
                        ];
                    }
                });
        }

        return $response;
    }

    /**
     * Checa role
     */
    public function checkIfHasRole()
    {   
        $has_role = AdminService::checkIfIsAdmin($this->user);

        if (!$has_role) {
            $query = Role::select('id', 'slug')->whereSlug($this->role);

            if ($query->exists()) {
                $has_role = RoleUser::whereUserId($this->user->id)
                    ->whereRoleId($query->first()->id)
                    ->exists();
            }
        }        

        return $has_role;
    }

    /**
     * Registra role
     */
    public function registerNewRole()
    {
        $role_registered = false;
        $query = Role::select('id', 'slug')->whereSlug($this->role);

        if ($query->exists()) {
            $role = $query->with('permissions')->first();

            $role_registered = RoleUser::firstOrNew([
                'user_id' => $this->user->id,
                'role_id' => $role->id
            ])->save();

            foreach ($role->permissions as $permission) {
                PermissionUser::create(['user_id' => $this->user->id, 'permission_id' => $permission->id]);
            }
        }

        return $role_registered;
    }

    /**
     * Revoga role
     */
    public function deleteRole()
    {
        $role_deleted = false;
        $query = Role::select('id', 'slug')->whereSlug($this->role);

        if ($query->exists()) {
            $role_deleted = RoleUser::whereUserId($this->user->id)->whereRoleId($query->first()->id)->delete();
        }

        return $role_deleted;
    }
}
