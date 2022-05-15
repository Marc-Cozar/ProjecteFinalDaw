<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('home')->with(['retCode' => '1', 'msj' => 'Error you are not logged']);
        }

        if (!auth()->check() || auth()->user()->role_id === 0) {

            return redirect()->route('home')->with(['retCode' => '1', 'msj' => 'Error you don\'t have permission']);
        }

        return $next($request);
    }
}
