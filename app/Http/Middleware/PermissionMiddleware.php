<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permissions
     * @return mixed
     */
    public function handle($request, Closure $next,  $requiredPermission = null)
    {

         // Get the authenticated user
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Get user's role (assuming one role per user)
        $role = $user->roles->first();  // Assuming many-to-many relationship

        // Check if user role exists
        if (!$role) {
            abort(403, 'Unauthorized action.');
        }

        // Get the permissions for the user's role
        $rolePermissions = $role->permissions->pluck('name'); // Assuming permissions are stored in a 'name' column

        // Check if the role has the required permission
        if ($requiredPermission && !$rolePermissions->contains($requiredPermission)) {
            // If the role doesn't have the permission, deny access
            abort(403, 'Unauthorized action.');
        }

        // If permission is granted, proceed with the request
        return $next($request);
    }
}
