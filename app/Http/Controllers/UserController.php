<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display list of users.
     */
    public function index()
    {
        $users = User::with('role')->paginate(10);
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Store new user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'second_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = 'active';

        User::create($validated);

        return back()->with('success', 'User created successfully.');
    }

    /**
     * Update user details and role.
     */
    public function update(Request $request, User $user)
    {
        // Security check: Non-master-admins cannot edit a Master Admin account
        if ($user->hasRole('master-admin') && !auth()->user()->hasRole('master-admin')) {
            return back()->with('error', 'Only a Master Admin can edit Master Admin accounts.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'second_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
            'status' => ['nullable', 'in:active,inactive,pending'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        // Security check: non-master-admins cannot assign master-admin role
        $targetRole = Role::find($validated['role_id']);
        if ($targetRole && $targetRole->slug === 'master-admin' && !auth()->user()->hasRole('master-admin')) {
            return back()->with('error', 'Only a Master Admin can assign the Master Admin role.');
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        if (empty($validated['status'])) {
            unset($validated['status']);
        }

        $user->update($validated);

        return back()->with('success', "User account '{$user->name}' updated successfully.");
    }

    /**
     * Delete user.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own active account.');
        }

        // Security check: Non-master-admins cannot delete a Master Admin account
        if ($user->hasRole('master-admin') && !auth()->user()->hasRole('master-admin')) {
            return back()->with('error', 'Only a Master Admin can delete Master Admin accounts.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}
