<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckServiceRejection
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->has_rejected_service === 'true') {
            return redirect()->route('home')->with('error', 'You currently have rejected service and cannot accept a new one.');
        }

        return $next($request);
    }
}
