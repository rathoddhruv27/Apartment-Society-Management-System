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
                <div class="relative">
                    <input type="password" id="create-password" name="password" required class="w-full pl-3 pr-10 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-indigo-500" placeholder="••••••••">
                    <button type="button" onclick="toggleCreatePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-indigo-600 focus:outline-none transition">
                        <svg id="eye-icon-create" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eye-off-icon-create" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="sm:col-span-2 lg:col-span-5 flex justify-end">
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs transition shadow-lg">
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

<script>
    function toggleCreatePassword() {
        const passwordInput = document.getElementById('create-password');
        const eyeIcon = document.getElementById('eye-icon-create');
        const eyeOffIcon = document.getElementById('eye-off-icon-create');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeOffIcon.classList.add('hidden');
        }
    }
</script>
@endsection
