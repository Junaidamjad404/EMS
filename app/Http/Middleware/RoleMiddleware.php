<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {
         // Check if the user is logged in and has the required role
        if (Auth::check() && Auth::user()->hasRole($role) ) {
            return $next($request); // Proceed to the next request
        }
       

         return redirect()->back()->withErrors(['message' => 'Unauthorized access']);
    }
}
