<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Display roles & permissions matrix.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all()->groupBy('module');

        return view('roles.index', compact('roles', 'permissions'));
    }

    /**
     * Update permissions assigned to a role.
     */
    public function updatePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->permissions()->sync($request->input('permissions', []));

        return back()->with('success', "Permissions for role '{$role->name}' updated successfully.");
    }
}
