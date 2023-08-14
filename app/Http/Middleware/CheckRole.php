<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Check if the authenticated user has user_role = 0
        if ($request->user() && $request->user()->role == 'admin') {
            return $next($request);
        }

        // If user_role is not 0, redirect back with an error message
        return redirect()->back()->with('error', 'You are not authorized to access this page.');
    }
}
