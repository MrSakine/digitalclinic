<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ... $roles)
    {
        foreach($roles as $role) {
            if (session('type') === $role) {
                return $next($request);
            }
        }

        return redirect()->route('index');
    }
}
