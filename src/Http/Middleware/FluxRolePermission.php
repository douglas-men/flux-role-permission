<?php

namespace Doc88\FluxRolePermission\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class FluxRolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if ($request->user()->admin || $request->user()->hasRole('admin')) {
            return $next($request);
        }

        if (!$request->user()->hasPermission($permission)) {
            return response(['error' => 'Permissões insuficientes.'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
