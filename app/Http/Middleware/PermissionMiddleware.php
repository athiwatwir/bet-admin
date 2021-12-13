<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Log;

use Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission = null)
    {
        // $authGuard = app('auth')->guard($guard);
        // if($authGuard->guard()) {
        //     throw UnauthorizedException::notLoggedIn();
        // }

        // Log::debug($permission);

        switch ($permission) {
            case 'user' : 
                if(session('_p')['user']) {
                    return $next($request);
                }else{
                    return redirect()->back()->with('error','คุณไม่มีสิทธิ์เข้าถึงหน้านี้...');
                }
            case 'level' : {
                if(session('_p')['level']) {
                    return $next($request);
                }else{
                    return redirect()->back()->with('error','คุณไม่มีสิทธิ์เข้าถึงหน้านี้...');
                }
            }
            case 'admin' : 
                if(session('_p')['admin']) {
                    return $next($request);
                }else{
                    return redirect()->back()->with('error','คุณไม่มีสิทธิ์เข้าถึงหน้านี้...');
                }
            case 'role' : 
                if(session('_p')['role']) {
                    return $next($request);
                }else{
                    return redirect()->back()->with('error','คุณไม่มีสิทธิ์เข้าถึงหน้านี้...');
                }
            case 'transaction' :
                if(session('_p')['payment_transaction']) {
                    return $next($request);
                }else{
                    return redirect()->back()->with('error','คุณไม่มีสิทธิ์เข้าถึงหน้านี้...');
                }
            case 'adjust' :
                if(session('_p')['adjust']) {
                    return $next($request);
                }else{
                    return redirect()->back()->with('error','คุณไม่มีสิทธิ์เข้าถึงหน้านี้...');
                }
            default:
                return redirect()->back()->with('error','คุณไม่มีสิทธิ์เข้าถึงหน้านี้...');
        }

        return redirect()->back()->with('error','คุณไม่มีสิทธิ์เข้าถึงหน้านี้...');
    }
}
