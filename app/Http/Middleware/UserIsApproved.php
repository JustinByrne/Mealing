<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsApproved
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
        if (!Auth::user()->approved) {
            
            Auth::logout();
            $request->session()->flash('message', 'Account is currently awaiting approval.');
            
            return redirect()->route('login');
        }
        
        return $next($request);
    }
}
