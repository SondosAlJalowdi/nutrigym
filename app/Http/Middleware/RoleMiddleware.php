<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;




class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $user->load('roles'); // eager load roles to avoid errors

        $roleNames = $user->roles->pluck('name')->toArray();

        if (!array_intersect($roleNames, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
