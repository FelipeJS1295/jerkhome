<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle($request, Closure $next, $type)
    {
        if (!Auth::check() || Auth::user()->type !== $type) {
            return redirect('/');
        }

        return $next($request);
    }
}
