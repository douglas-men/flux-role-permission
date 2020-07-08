<?php

namespace Doc88\FluxRolePermission\Repositories;

use Doc88\FluxRolePermission\Models\Permission;
use Doc88\FluxRolePermission\Models\PermissionRole;
use Doc88\FluxRolePermission\Models\Role;
use Doc88\FluxRolePermission\Models\RoleUser;

class RoleRepository {

    public static function getAll()
    {
        return Role::with('permissions')->select('id', 'name', 'slug')->get()->transform(function ($item) {
            $retorno = [
                'id'    => $item->id,
                'name'  => $item->name,
                'slug'  => $item->slug
            ];

            if (!empty($item->permissions) && count($item->permissions) > 0) {
                $retorno += ['permissions' => $item->permissions->transform(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'slug' => $item->slug
                    ];
                })];
            }

            return $retorno;
        });
    }

    public static function store($slug, $permissions = null)
    {
        $name = '';
        $exploded_slug = explode('-', $slug);

        foreach ($exploded_slug as $index => $string) {
            $name .= ucfirst($string);

            if (isset($exploded_slug[$index+1])) {
                $name .= ' ';
            }
        }

        $role = Role::firstOrNew(['name' => $name, 'slug' => $slug]);
        $role->save();

        if (!is_null($permissions) && !empty($permissions)) {
            self::vincularPermissoes($role->id, $permissions);
        }

        return $role->save();
    }

    public static function delete($slug)
    {
        $role_deleted = false;
        $query = Role::whereSlug($slug);

        if ($query->exists()) {

            $role = $query->first();

            PermissionRole::whereRoleId($role->id)->delete();
            RoleUser::whereRoleId($role->id)->delete();

            $role_deleted = $role->delete();
        }

        return $role_deleted;
    }

    public static function addPermission($slug, $permission)
    {
        $permission_added = false;
        $query_role = Role::select('id', 'slug')->whereSlug($slug);
        $query_permission = Permission::select('id', 'slug')->whereSlug($permission);

        if ($query_role->exists() && $query_permission->exists()) {
            $permission_role = PermissionRole::firstOrNew([
                'permission_id' => $query_permission->first()->id,
                'role_id'       => $query_role->first()->id
            ]);

            $permission_added = $permission_role->save();
        }

        return $permission_added;
    }

    public static function removePermission($slug, $permission)
    {
        $permission_removed = false;
        $query_role = Role::select('id', 'slug')->whereSlug($slug);
        $query_permission = Permission::select('id', 'slug')->whereSlug($permission);

        if ($query_role->exists() && $query_permission->exists()) {
            $permission_removed = PermissionRole::wherePermissionId($query_permission->first()->id)
                ->whereRoleId($query_role->first()->id)->delete();
        }

        return $permission_removed;
    }

    private static function vincularPermissoes($role_id, $permissions)
    {
        foreach ($permissions as $permission) {

            $query = Permission::whereSlug($permission);

            if ($query->exists()) {
                $permission_role = PermissionRole::firstOrNew([
                    'permission_id' => $query->first()->id,
                    'role_id' => $role_id
                ]);

                $permission_role->save();
            }
        }
    }
}
