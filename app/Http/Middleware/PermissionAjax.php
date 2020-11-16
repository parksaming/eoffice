<?php

namespace App\Http\Middleware;

use Closure;

class PermissionAjax
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // get key action
        $action = $request->route()->getAction();
        $keyAction = str_replace('controller@', '.', strtolower(substr($action['controller'], (strrpos($action['controller'], '\\'))? strrpos($action['controller'], '\\')+1 : 0)));
        
        // check permission of key
        if (!checkPermission($keyAction)) {
            throw new \App\Exceptions\PermissionAjaxException;
        }
        
        return $next($request);
    }
}
