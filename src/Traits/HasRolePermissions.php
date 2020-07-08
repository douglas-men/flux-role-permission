<?php

namespace Doc88\FluxRolePermission\Traits;

use Doc88\FluxRolePermission\Services\PermissionService;
use Doc88\FluxRolePermission\Services\RoleService;

trait HasRolePermissions {

    //-------------------------------------------------------
    //                      PERMISSIONS
    //-------------------------------------------------------

    /**
     * Lista as permissões do usuário
     */
    public function listPermissions()
    {
        return (new PermissionService($this))->listPermissions();
    }

    /**
     * Verifica se o usuário possui a permissão
     */
    public function hasPermission($permission)
    {
        return (new PermissionService($this, $permission))->checkIfHasPermission();
    }

    /**
     * Registra uma nova permissão para o usuário
     */
    public function registerPermission($permission)
    {
        return (new PermissionService($this, $permission))->registerNewPermission();
    }

    /**
     * Revoga uma permissão do usuário
     */
    public function revokePermission($permission)
    {
        return (new PermissionService($this, $permission))->deletePermission();
    }

    //-------------------------------------------------------
    //                        ROLES
    //-------------------------------------------------------

    /**
     * Lista as roles do usuário
     */
    public function listRoles()
    {
        return (new RoleService($this))->listRoles();
    }

    /**
     * Verifica se o usuário possui a role
     */
    public function hasRole($role)
    {
        return (new RoleService($this, $role))->checkIfHasRole();
    }

    /**
     * Registra uma nova role para o usuário
     */
    public function registerRole($role)
    {
        return (new RoleService($this, $role))->registerNewRole();
    }

    /**
     * Revoga uma role do usuário
     */
    public function revokeRole($role)
    {
        return (new RoleService($this, $role))->deleteRole();
    }
}
