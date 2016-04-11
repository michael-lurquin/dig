<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if ( Auth()->check() )
        {
            if ( $request->user()->can($permission) )
            {
                return $next($request);
            }
            else
            {
                return abort(401, 'Access denied');
            }
        }
        else
        {
            return abort(403, 'Unauthenticated user');
        }

        return $request->ajax ? abort(401, 'Access denied') : redirect(url('/login'));
    }
}
