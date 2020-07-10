<?php

namespace Doc88\FluxRolePermission\Services;

use Doc88\FluxRolePermission\Models\Role;
use Doc88\FluxRolePermission\Models\RoleUser;

class AdminService {

    /**
     * Verifica se o usuário é admin
     */
    public static function checkIfIsAdmin($user)
    {
        $is_admin = $user->admin ?? false;

        if (!$is_admin) {
            $query_role_admin = Role::whereSlug('admin');

            if ($query_role_admin->exists()) {
                $role_admin_id = $query_role_admin->first()->id;
                $is_admin = RoleUser::whereRoleId($role_admin_id)->whereUserId($user->id)->exists();
            }
        }

        return $is_admin;
    }
}
