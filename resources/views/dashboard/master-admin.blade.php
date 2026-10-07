@extends('layouts.app')

@section('title', 'Master Admin Control Center')

@section('content')
<div class="space-y-6">

    <!-- Header Alert Banner -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-purple-100 via-indigo-50 to-white border border-purple-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-purple-700 text-xs font-bold uppercase tracking-wider mb-1.5">
                <span>👑 Full System Control Mode</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900">System Administration Dashboard</h2>
            <p class="text-sm text-slate-600 mt-1 font-medium">You have full root access to system settings, RBAC role matrices, permissions, and society metrics.</p>
        </div>
        <a href="{{ route('roles.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold transition shadow-lg shadow-purple-500/25 whitespace-nowrap">
            Manage Permissions &rarr;
        </a>
    </div>

    <!-- System Overview Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Users</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-2">{{ $stats['total_users'] }}</h3>
            <p class="text-xs font-medium text-purple-600 mt-1.5 bg-purple-50 inline-block px-2 py-0.5 rounded-md">Across all 4 system roles</p>
        </div>

        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Active Roles</p>
            <h3 class="text-3xl font-extrabold text-purple-600 mt-2">{{ $stats['total_roles'] }}</h3>
            <p class="text-xs font-medium text-slate-600 mt-1.5">master-admin, admin, user, guard</p>
        </div>

        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">System Permissions</p>
            <h3 class="text-3xl font-extrabold text-indigo-600 mt-2">{{ $stats['total_permissions'] }}</h3>
            <p class="text-xs font-medium text-slate-600 mt-1.5">Granular access rights</p>
        </div>

        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Buildings Registered</p>
            <h3 class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $stats['total_buildings'] }}</h3>
            <p class="text-xs font-medium text-slate-600 mt-1.5">Society blocks</p>
        </div>
    </div>

    <!-- Active Roles Breakdowns -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-6 rounded-2xl">
            <h3 class="text-lg font-extrabold text-slate-900 mb-5">Role Distribution</h3>
            <div class="space-y-3">
                @foreach($roles as $role)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between group hover:border-indigo-200 hover:bg-indigo-50/30 transition">
                        <div>
                            <span class="text-sm font-bold text-slate-900 group-hover:text-indigo-700 transition">{{ $role->name }}</span>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $role->description }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1.5 rounded-lg bg-indigo-100 text-indigo-700 text-xs font-bold border border-indigo-200">
                                {{ $role->users_count }} Users
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl">
            <h3 class="text-lg font-extrabold text-slate-900 mb-5">Recent User Accounts</h3>
            <div class="space-y-3">
                @foreach($recentUsers as $u)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between group hover:border-slate-200 transition">
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $u->name }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $u->email }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border {{ $u->hasRole('master-admin') ? 'bg-purple-100 border-purple-200 text-purple-700' : ($u->hasRole('admin') ? 'bg-blue-100 border-blue-200 text-blue-700' : ($u->hasRole('security-guard') ? 'bg-amber-100 border-amber-200 text-amber-700' : 'bg-emerald-100 border-emerald-200 text-emerald-700')) }}">
                            {{ $u->role ? $u->role->name : 'No Role' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
