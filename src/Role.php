<?php

namespace Doc88\FluxRolePermission;

use Doc88\FluxRolePermission\Repositories\RoleRepository;
use Doc88\FluxRolePermission\Services\RoleService;

class Role {

    //-------------------------------------------------------
    //                   FUNÇÕES DO USUÁRIO
    //-------------------------------------------------------

    /**
     * Lista as roles do usuário
     */
    public static function list($user)
    {
        return (new RoleService($user))->listRoles();
    }

    /**
     * Verifica se o usuário possui a role
     */
    public static function has($user, $role)
    {
        return (new RoleService($user, $role))->checkIfHasRole();
    }

    /**
     * Registra uma nova role para o usuário
     */
    public static function register($user, $role)
    {
        return (new RoleService($user, $role))->registerNewRole();
    }

    /**
     * Revoga a role de um usuário
     */
    public static function revoke($user, $role)
    {
        return (new RoleService($user, $role))->deleteRole();
    }

    //-------------------------------------------------------
    //                   FUNÇÕES DA ROLE
    //-------------------------------------------------------

    /**
     * Retorna uma lista com todas
     * as roles registradas no banco
     */
    public static function all()
    {
        return RoleRepository::getAll();
    }

    /**
     * Cria uma nova role no banco
     */
    public static function create($slug, $permissions = null)
    {
        return RoleRepository::store($slug, $permissions);
    }

    /**
     * Exclui uma role do banco
     */
    public static function delete($slug)
    {
        return RoleRepository::delete($slug);
    }

    /**
     * Adiciona uma permissão a uma role
     */
    public static function addPermission($slug, $permission)
    {
        return RoleRepository::addPermission($slug, $permission);
    }

    /**
     * Remove uma permissão da role
     */
    public static function removePermission($slug, $permission)
    {
        return RoleRepository::removePermission($slug, $permission);
    }
}
