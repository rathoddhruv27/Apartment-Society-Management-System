@extends('layouts.app')

@section('title', 'Society Admin Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-blue-900/60 via-indigo-900/60 to-slate-900 border border-blue-500/30 shadow-xl">
        <span class="text-blue-400 text-xs font-bold uppercase tracking-wider">🛡️ Society Administrator</span>
        <h2 class="text-2xl font-extrabold text-white mt-1">Application & User Operations</h2>
        <p class="text-sm text-blue-200/80 mt-1">Manage society residents, apartment allocations, visitor logs, and resident complaints.</p>
    </div>

    <!-- Admin Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Registered Users</p>
            <h3 class="text-3xl font-extrabold text-white mt-2">{{ $stats['total_users'] }}</h3>
            <p class="text-xs text-blue-400 mt-1">Residents & Staff</p>
        </div>

        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Buildings / Blocks</p>
            <h3 class="text-3xl font-extrabold text-blue-400 mt-2">{{ $stats['total_buildings'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">Managed blocks</p>
        </div>

        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Open Complaints</p>
            <h3 class="text-3xl font-extrabold text-amber-400 mt-2">{{ $stats['open_complaints'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">Pending resolution</p>
        </div>
        
        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Today's Visitors</p>
            <h3 class="text-3xl font-extrabold text-emerald-400 mt-2">{{ $stats['today_visitors'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">Gate check-ins</p>
        </div>
    </div>

    <!-- Active Management Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-6 rounded-2xl border border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white">Recent Complaints</h3>
                <a href="{{ route('complaints.index') }}" class="text-xs font-semibold text-blue-400 hover:underline">View All &rarr;</a>
            </div>
            <div class="space-y-3">
                @forelse($recentComplaints as $c)
                    <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-white">{{ $c->title }}</p>
                            <p class="text-xs text-slate-400">By {{ $c->user->name ?? 'Resident' }} • {{ $c->category }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase {{ $c->status === 'resolved' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-amber-500/20 text-amber-300' }}">
                            {{ $c->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No complaints filed yet.</p>
                @endforelse
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl border border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white">Gate Visitor Activity</h3>
                <a href="{{ route('visitors.index') }}" class="text-xs font-semibold text-blue-400 hover:underline">View Desk &rarr;</a>
            </div>
            <div class="space-y-3">
                @forelse($recentVisitors as $v)
                    <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-white">{{ $v->name }}</p>
                            <p class="text-xs text-slate-400">Purpose: {{ $v->purpose }} • {{ $v->phone }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase {{ $v->status === 'checked_in' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-slate-800 text-slate-400' }}">
                            {{ $v->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No visitor entries today.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
