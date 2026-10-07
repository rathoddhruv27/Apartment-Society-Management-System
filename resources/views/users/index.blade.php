@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">User Accounts & Role Assignments</h2>
            <p class="text-xs text-slate-500">Manage user accounts and assign one of the 4 system roles.</p>
        </div>
    </div>

    <!-- Create User Card -->
    <div class="glass-card p-6 rounded-2xl border border-slate-200">
        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Add New User Account</h3>
        <form action="{{ route('users.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @csrf
            <div>
                <label class="block text-xs text-slate-500 mb-1">Full Name</label>
                <input type="text" name="name" required class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-indigo-500" placeholder="Jane Doe">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Email Address</label>
                <input type="email" name="email" required class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-indigo-500" placeholder="user@domain.com">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Phone Number</label>
                <input type="text" name="phone" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-indigo-500" placeholder="+1234567890">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Assigned Role</label>
                <select name="role_id" required class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-indigo-500">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }} ({{ $role->slug }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-indigo-500" placeholder="••••••••">
            </div>

            <div class="sm:col-span-2 lg:col-span-5 flex justify-end">
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-slate-900 font-semibold text-xs transition shadow-lg">
                    + Create Account
                </button>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="glass-card rounded-2xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase border-b border-slate-200">
                    <tr>
                        <th class="p-4">User</th>
                        <th class="p-4">Contact</th>
                        <th class="p-4">Assigned Role</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($users as $u)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 font-semibold text-slate-900">
                                {{ $u->name }}
                            </td>
                            <td class="p-4">
                                <div>{{ $u->email }}</div>
                                <div class="text-slate-500 text-[10px]">{{ $u->phone ?? 'No phone' }}</div>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase {{ $u->hasRole('master-admin') ? 'bg-purple-100 text-purple-700 border border-purple-200' : ($u->hasRole('admin') ? 'bg-blue-100 text-blue-700 border border-blue-200' : ($u->hasRole('security-guard') ? 'bg-amber-100 text-amber-700 border border-amber-200' : 'bg-emerald-100 text-emerald-700 border border-emerald-200')) }}">
                                    {{ $u->role ? $u->role->name : 'No Role' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    {{ $u->status ?? 'active' }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                @if($u->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $u) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-rose-300 font-semibold">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection
