<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveOrganizerOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Get the authenticated user
        $user = Auth::user();

        // Check if the user is an admin or an active event organizer
        if ($user && ($user->hasRole('admin') || ($user->hasRole('event_organizer')  && $user->active_organizer === 1))) {
            return $next($request); // Allow access
        }else if($user && $user->hasRole('event_organizer')){
            return redirect()->route('organizer.not_approved');
        }
        return redirect()->back()->with('error', 'You do not have access to this resource.');
    }
}
