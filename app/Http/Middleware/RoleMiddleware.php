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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            // Redirect based on role if logged in but unauthorized for this route
            if (Auth::check()) {
                if (in_array(Auth::user()->role, ['super_admin', 'wakil_admin', 'admin'])) {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('dashboard'); // normal user dashboard
            }
            
            return redirect('login');
        }

        return $next($request);
    }
}
