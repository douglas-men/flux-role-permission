<?php

namespace Doc88\FluxRolePermission\Services;

use Doc88\FluxRolePermission\Models\Permission;
use Doc88\FluxRolePermission\Models\PermissionUser;
use Doc88\FluxRolePermission\Models\Role;
use Doc88\FluxRolePermission\Models\RoleUser;

class PermissionService {

    protected $user;
    protected $permission;

    public function __construct($user, $permission = null)
    {
        $this->user = $user;
        $this->permission = $permission;
    }

    /**
     * Lista as permissões
     */
    public function listPermissions()
    {   
        if (AdminService::checkIfIsAdmin($this->user)) {
            $response = Permission::get()->transform(function ($item) {
                return [
                    'id'   => $item->id,
                    'name' => $item->name,
                    'slug' => $item->slug
                ];
            });
        } else {
            $response = PermissionUser::with(['permission' => function ($query) {
                $query->select('id', 'name', 'slug');
            }])
            ->whereUserId($this->user->id)
            ->get(['id', 'user_id', 'permission_id'])
            ->transform(function ($item) {
                if (!empty($item->permission)) {
                    return [
                        'id'   => $item->permission->id,
                        'name' => $item->permission->name,
                        'slug' => $item->permission->slug
                    ];
                }
            });
        }

        return $response;
    }

    /**
     * Checa permissão
     */
    public function checkIfHasPermission()
    {
        $has_permission = AdminService::checkIfIsAdmin($this->user);

        if (!$has_permission) {
            $query = Permission::select('id', 'slug')->whereSlug($this->permission);

            if ($query->exists()) {
                $has_permission = PermissionUser::whereUserId($this->user->id)
                    ->wherePermissionId($query->first()->id)
                    ->exists();
            }
        }

        return $has_permission;
    }

    /**
     * Registra permissão
     */
    public function registerNewPermission()
    {
        $permission_registered = false;
        $query = Permission::select('id', 'slug')->whereSlug($this->permission);

        if ($query->exists()) {
            $permission_registered = PermissionUser::firstOrNew([
                'user_id' => $this->user->id,
                'permission_id' => $query->first()->id
            ])->save();
        }

        return $permission_registered;
    }

    /**
     * Revoga permissão
     */
    public function deletePermission()
    {
        $permission_deleted = false;
        $query = Permission::select('id', 'slug')->whereSlug($this->permission);

        if ($query->exists()) {
            $permission_deleted = PermissionUser::whereUserId($this->user->id)
                ->wherePermissionId($query->first()->id)
                ->delete();
        }

        return $permission_deleted;
    }
}
