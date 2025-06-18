<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;




class RoleMiddleware
{

    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $roleNames = $user->role;

        if (!array_intersect($roleNames, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
