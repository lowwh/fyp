<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Get the authenticated user from the request
        $user = $request->user();

        // Check if the user is authenticated and if their role is not 'admin'
        if ($user instanceof User && $user->role !== 'admin') {
            // If the user's role is not 'admin', redirect
            return redirect()->route('home');
        }

        // If the user is authenticated and their role is 'admin' or the user is not authenticated, proceed with the request
        return $next($request);
    }
}
