<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('welcome')->with('error', 'Please log in to access this page.');
        }

        if (auth()->user()->role !== 'admin') {
            return redirect()->route('welcome')->with('error', 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}
