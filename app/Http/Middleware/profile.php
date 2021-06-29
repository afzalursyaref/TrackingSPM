<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class profile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!auth()->user()->profile()->exists()){
            return redirect()->route('profile.index');
        }
        return $next($request);
    }
}
