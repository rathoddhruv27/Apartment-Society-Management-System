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
     * Update user role / status.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
            'status' => ['required', 'in:active,inactive,pending'],
        ]);

        $user->update($validated);

        return back()->with('success', "User '{$user->name}' updated successfully.");
    }

    /**
     * Delete user.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own active account.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}
