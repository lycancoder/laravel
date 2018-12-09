<?php
/**
 * Created by PhpStorm.
 * User: Lycan
 * Date: 2018/12/9
 * Time: 17:07
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class AdminUserPermission
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
        $route = Route::currentRouteName();
        if (!session()->has('LoginUserPermission')) {
            return redirect()->route('admin.index.login');
        }

        if (!isset(session('LoginUserPermission')[$route])) {
            if (Request::ajax()) {
                return response()->json(returnCode(0, '您没有操作权限'));
            } else {
                $request->flash();
                return redirect()->back()->withErrors('您没有操作权限');
            }
        }

        return $next($request);
    }
}