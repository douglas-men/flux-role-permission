<?php

namespace Doc88\FluxRolePermission;

use Doc88\FluxRolePermission\Repositories\PermissionRepository;
use Doc88\FluxRolePermission\Services\PermissionService;

class Permission {

    //-------------------------------------------------------
    //                   FUNÇÕES DO USUÁRIO
    //-------------------------------------------------------

    /**
     * Lista as permissões do usuário
     */
    public static function list($user)
    {
        return (new PermissionService($user))->listPermissions();
    }

    /**
     * Verifica se o usuário possui permissão
     */
    public static function has($user, $permission)
    {
        return (new PermissionService($user, $permission))->checkIfHasPermission();
    }

    /**
     * Registra uma nova permissão para o usuário
     */
    public static function register($user, $permission)
    {
        return (new PermissionService($user, $permission))->registerNewPermission();
    }

    /**
     * Revoga a permissão de um usuário
     */
    public static function revoke($user, $permission)
    {
        return (new PermissionService($user, $permission))->deletePermission();
    }

    //-------------------------------------------------------
    //                   FUNÇÕES DA PERMISSÃO
    //-------------------------------------------------------

    /**
     * Retorna uma lista com todas
     * as permissões registradas no banco
     */
    public static function all()
    {
        return PermissionRepository::getAll();
    }

    /**
     * Retorna uma permissão registrada no banco
     */
    public static function get($slug)
    {
        return PermissionRepository::getOne($slug);
    }

    /**
     * Cria uma nova permissão no banco
     */
    public static function create($slug)
    {
        return PermissionRepository::store($slug);
    }

    /**
     * Exclui uma permissão do banco
     */
    public static function delete($slug)
    {
        return PermissionRepository::delete($slug);
    }
}
