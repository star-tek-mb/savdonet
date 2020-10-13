<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role_string)
    {
        if (Auth::check()) {
            $roles = explode('|', $role_string);
            if (in_array(Auth::user()->role, $roles)) {
                return $next($request);
            }
        }
        throw new AuthorizationException('You do not have permission to view this page');
    }
}