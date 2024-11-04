<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    // Show roles and permissions management page
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('admin.role_permissions.index', compact('roles', 'permissions'));
    }

    // Store a new role
    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles']);
        Role::create($request->all());
        return redirect()->back()->with('success', 'Role created successfully!');
    }

    // Store a new permission
    public function storePermission(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions']);
        Permission::create($request->all());
        return redirect()->back()->with('success', 'Permission created successfully!');
    }
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return response()->json($role);
    }

    // Assign permissions to a role
    public function assignPermissions(Request $request, Role $role)
    {
            $validatedData = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id', // Validate that each permission exists
        ]);

        // Sync permissions without duplicating
        $role->permissions()->sync($validatedData['permissions']);
        return redirect()->back()->with('success', 'Permissions assigned successfully!');
    }

    // Remove a role
    public function destroyRole(Role $role)
    {
        // $role->permissions()->detach();
        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully!');
    }

    // Remove a permission
    public function destroyPermission(Permission $permission)
    {
        $permission->delete();
        return redirect()->back()->with('success', 'Permission deleted successfully!');
    }
}
