<?php

namespace App\Http\Middleware;

use Closure;

class AdminCheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session()->has('loginUser')) {
            return redirect()->route('admin.index.login');
        }
//        view()->share('user', session('loginUser'));

        return $next($request);
    }
}
