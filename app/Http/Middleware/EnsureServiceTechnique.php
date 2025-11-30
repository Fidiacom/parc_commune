<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureServiceTechnique
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $role = \App\Models\Role::find($user->getRoleId());

        if ($role && ($role->getLabel() !== 'Service Technique' || $role->getLabel() !== 'Administrateur')) {
            return $next($request);
        }

        abort(403, 'Unauthorized access. This page is only accessible to Service Technique users.');
    }
}

