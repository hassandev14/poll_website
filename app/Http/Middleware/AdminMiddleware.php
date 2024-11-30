<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the 'admin' role
        if (auth()->check() && auth()->user()->role == 'admin') {
            return $next($request);  // Allow the request to proceed
        }

        // Redirect to dashboard if not an admin
        return redirect()->route('/polls')->with('error', 'You are not authorized to access this page.');
    }
}
