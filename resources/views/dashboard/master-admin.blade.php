@extends('layouts.app')

@section('title', 'Master Admin Control Center')

@section('content')
<div class="space-y-6">

    <!-- Header Alert Banner -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-purple-900/60 via-indigo-900/60 to-slate-900 border border-purple-500/30 shadow-xl flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2 text-purple-400 text-xs font-bold uppercase tracking-wider mb-1">
                <span>👑 Full System Control Mode</span>
            </div>
            <h2 class="text-2xl font-extrabold text-white">System Administration Dashboard</h2>
            <p class="text-sm text-purple-200/80 mt-1">You have full root access to system settings, RBAC role matrices, permissions, and society metrics.</p>
        </div>
        <a href="{{ route('roles.index') }}" class="hidden sm:inline-flex items-center px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold transition shadow-lg shadow-purple-600/30">
            Manage System Permissions &rarr;
        </a>
    </div>

    <!-- System Overview Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Users</p>
            <h3 class="text-3xl font-extrabold text-white mt-2">{{ $stats['total_users'] }}</h3>
            <p class="text-xs text-purple-400 mt-1">Across all 4 system roles</p>
        </div>

        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Active Roles</p>
            <h3 class="text-3xl font-extrabold text-purple-400 mt-2">{{ $stats['total_roles'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">master-admin, admin, user, guard</p>
        </div>

        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">System Permissions</p>
            <h3 class="text-3xl font-extrabold text-indigo-400 mt-2">{{ $stats['total_permissions'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">Granular access rights</p>
        </div>

        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Buildings Registered</p>
            <h3 class="text-3xl font-extrabold text-emerald-400 mt-2">{{ $stats['total_buildings'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">Society blocks</p>
        </div>
    </div>

    <!-- Active Roles Breakdowns -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-6 rounded-2xl border border-slate-800">
            <h3 class="text-lg font-bold text-white mb-4">Role Distribution</h3>
            <div class="space-y-3">
                @foreach($roles as $role)
                    <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center justify-between">
                        <div>
                            <span class="text-sm font-semibold text-white">{{ $role->name }}</span>
                            <p class="text-xs text-slate-400">{{ $role->description }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-2.5 py-1 rounded-lg bg-indigo-500/10 text-indigo-400 text-xs font-bold">
                                {{ $role->users_count }} Users
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl border border-slate-800">
            <h3 class="text-lg font-bold text-white mb-4">Recent User Accounts</h3>
            <div class="space-y-3">
                @foreach($recentUsers as $u)
                    <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-white">{{ $u->name }}</p>
                            <p class="text-xs text-slate-400">{{ $u->email }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase {{ $u->hasRole('master-admin') ? 'bg-purple-500/20 text-purple-300' : ($u->hasRole('admin') ? 'bg-blue-500/20 text-blue-300' : ($u->hasRole('security-guard') ? 'bg-amber-500/20 text-amber-300' : 'bg-emerald-500/20 text-emerald-300')) }}">
                            {{ $u->role ? $u->role->name : 'No Role' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
