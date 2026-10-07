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
                <input type="text" name="name" required class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition" placeholder="Jane Doe">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Email Address</label>
                <input type="email" name="email" required class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition" placeholder="user@domain.com">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Phone Number</label>
                <input type="text" name="phone" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition" placeholder="+1234567890">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Assigned Role</label>
                <select name="role_id" required class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                    @foreach($roles as $role)
                        @if($role->slug === 'master-admin' && !auth()->user()->hasRole('master-admin'))
                            @continue
                        @endif
                        <option value="{{ $role->id }}">{{ $role->name }} ({{ $role->slug }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Password</label>
                <div class="relative">
                    <input type="password" id="create-password" name="password" required class="w-full pl-3 pr-10 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition" placeholder="••••••••">
                    <button type="button" onclick="toggleCreatePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-emerald-600 focus:outline-none transition">
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
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition shadow-lg shadow-emerald-600/30">
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
                                {{ $u->full_name }}
                            </td>
                            <td class="p-4">
                                <div>{{ $u->email }}</div>
                                <div class="text-slate-500 text-[10px]">{{ $u->phone ?? 'No phone' }}</div>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase {{ $u->hasRole('master-admin') ? 'bg-purple-100 text-purple-700 border border-purple-200' : ($u->hasRole('admin') ? 'bg-teal-100 text-teal-700 border border-teal-200' : ($u->hasRole('security-guard') ? 'bg-amber-100 text-amber-700 border border-amber-200' : 'bg-emerald-100 text-emerald-700 border border-emerald-200')) }}">
                                    {{ $u->role ? $u->role->name : 'No Role' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    {{ $u->status ?? 'active' }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                @if($u->hasRole('master-admin') && !auth()->user()->hasRole('master-admin'))
                                    <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-400 font-bold text-xs border border-slate-200/80 cursor-not-allowed">
                                        Protected
                                    </span>
                                @else
                                    <button type="button" onclick="document.getElementById('edit-user-modal-{{ $u->id }}').classList.remove('hidden')" class="px-3 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition border border-slate-200 inline-flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </button>
                                    @if($u->id !== auth()->id())
                                        <button type="button" onclick="document.getElementById('delete-user-modal-{{ $u->id }}').classList.remove('hidden')" class="px-3 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs transition border border-rose-200 inline-flex items-center">
                                            <svg class="w-3.5 h-3.5 mr-1 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    @endif
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

@push('modals')
    <!-- User Modals rendered at root body level so overlay covers entire screen including top header & sidebar -->
    @foreach($users as $u)
        @if(!$u->hasRole('master-admin') || auth()->user()->hasRole('master-admin'))

            <!-- Edit User Modal -->
            <div id="edit-user-modal-{{ $u->id }}" class="fixed inset-0 z-[100] bg-slate-900/40 backdrop-blur-xs flex items-start justify-center pt-6 sm:pt-10 p-4 hidden overflow-y-auto text-left font-normal">
                <div class="glass-card w-full max-w-lg p-6 sm:p-8 rounded-3xl bg-white shadow-2xl relative animate-in fade-in zoom-in duration-150">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-extrabold text-slate-900">Edit User Account</h3>
                        <button type="button" onclick="document.getElementById('edit-user-modal-{{ $u->id }}').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center font-bold text-sm">✕</button>
                    </div>

                    <form action="{{ route('users.update', $u) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">First Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $u->name) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">2nd Name (Last Name)</label>
                                <input type="text" name="second_name" value="{{ old('second_name', $u->second_name) }}" placeholder="e.g. Smith" class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Email Address <span class="text-rose-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $u->email) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $u->phone) }}" placeholder="+1234567890" class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Assigned Role <span class="text-rose-500">*</span></label>
                                <select name="role_id" required class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                                    @foreach($roles as $role)
                                        @if($role->slug === 'master-admin' && !auth()->user()->hasRole('master-admin'))
                                            @continue
                                        @endif
                                        <option value="{{ $role->id }}" {{ $u->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }} ({{ $role->slug }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Account Status</label>
                                <select name="status" class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                                    <option value="active" {{ ($u->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ ($u->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="pending" {{ ($u->status ?? '') === 'pending' ? 'selected' : '' }}>Pending Approval</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">New Password <span class="text-slate-400 font-normal">(Leave blank to keep current)</span></label>
                            <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                        </div>

                        <div class="flex justify-end space-x-3 pt-3">
                            <button type="button" onclick="document.getElementById('edit-user-modal-{{ $u->id }}').classList.add('hidden')" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition">Cancel</button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/30 transition">Update Account</button>
                        </div>
                    </form>
                </div>
            </div>

            @if($u->id !== auth()->id())
                <!-- Delete User Modal -->
                <div id="delete-user-modal-{{ $u->id }}" class="fixed inset-0 z-[100] bg-slate-900/40 backdrop-blur-xs flex items-start justify-center pt-6 sm:pt-10 p-4 hidden overflow-y-auto text-left font-normal">
                    <div class="glass-card w-full max-w-md p-6 sm:p-8 rounded-3xl bg-white shadow-2xl relative text-center">
                        <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 mx-auto flex items-center justify-center mb-4 border border-rose-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>

                        <h3 class="text-xl font-extrabold text-slate-900">Delete User Account</h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Are you sure you want to delete user <strong class="text-slate-900 font-bold">"{{ $u->name }}"</strong> ({{ $u->email }})? This action cannot be undone.
                        </p>

                        <div class="flex items-center justify-center space-x-3 mt-6">
                            <button type="button" onclick="document.getElementById('delete-user-modal-{{ $u->id }}').classList.add('hidden')" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition">
                                Cancel
                            </button>
                            <form action="{{ route('users.destroy', $u) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-md shadow-rose-600/30 transition">
                                    Yes, Delete User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endforeach
@endpush

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
