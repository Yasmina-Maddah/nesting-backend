<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() && auth()->user()->user_type === 'admin') {
            return $next($request);
        }

        return redirect('/'); // Redirect non-admin users
    }
}

