<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedWithRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            return match (auth()->user()->role) {
                'user' => redirect()->route('user.dashboard'),
                'admin' => redirect()->route('admin.dashboard'),
                default => abort(403),
            };
        }

        return $next($request);
    }
}
