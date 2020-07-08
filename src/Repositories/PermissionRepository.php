<?php

namespace Doc88\FluxRolePermission\Repositories;

use Doc88\FluxRolePermission\Models\Permission;

class PermissionRepository {

    public static function getAll()
    {
        return Permission::select('id', 'name', 'slug')->get()->transform(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug
            ];
        });
    }

    public static function store($slug)
    {
        $name = '';
        $exploded_slug = explode('-', $slug);

        foreach ($exploded_slug as $index => $string) {
            $name .= ucfirst($string);

            if (isset($exploded_slug[$index + 1])) {
                $name .= ' ';
            }
        }

        $permission = Permission::firstOrNew(['name' => $name, 'slug' => $slug]);
        return $permission->save();
    }

    public static function delete($slug)
    {
        $permission_deleted = false;
        $query = Permission::whereSlug($slug);

        if ($query->exists()) {
            $permission_deleted = $query->delete();
        }

        return $permission_deleted;
    }
}
