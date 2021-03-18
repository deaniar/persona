<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class check_account
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {

        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($user->level_role == $role) {
            return $next($request);
        }

        return redirect('login');
        // return $next($request);
    }
}
