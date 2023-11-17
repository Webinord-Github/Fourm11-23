<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if ($request->is('register*')) {
            abort(404); // or redirect to a different route
        }
    
        return $next($request);
    }
}
