@extends('layouts.app')

@section('title', 'Society Admin Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-blue-100 via-indigo-50 to-white border border-blue-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-blue-700 text-xs font-bold uppercase tracking-wider mb-1.5">
                <span>Society Administrator</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 mt-1">Application & User Operations</h2>
            <p class="text-sm text-slate-600 mt-1 font-medium">Manage society residents, apartment allocations, visitor logs, and resident complaints.</p>
        </div>
    </div>

    <!-- Admin Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Registered Users</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-2">{{ $stats['total_users'] }}</h3>
            <p class="text-xs font-medium text-blue-600 mt-1.5 bg-blue-50 inline-block px-2 py-0.5 rounded-md">Residents & Staff</p>
        </div>

        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Buildings / Blocks</p>
            <h3 class="text-3xl font-extrabold text-blue-600 mt-2">{{ $stats['total_buildings'] }}</h3>
            <p class="text-xs font-medium text-slate-600 mt-1.5">Managed blocks</p>
        </div>

        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Open Complaints</p>
            <h3 class="text-3xl font-extrabold text-amber-600 mt-2">{{ $stats['open_complaints'] }}</h3>
            <p class="text-xs font-medium text-slate-600 mt-1.5">Pending resolution</p>
        </div>
        
        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Today's Visitors</p>
            <h3 class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $stats['today_visitors'] }}</h3>
            <p class="text-xs font-medium text-slate-600 mt-1.5">Gate check-ins</p>
        </div>
    </div>

    <!-- Active Management Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-6 rounded-2xl">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-extrabold text-slate-900">Recent Complaints</h3>
                <a href="{{ route('complaints.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 hover:underline">View All &rarr;</a>
            </div>
            <div class="space-y-3">
                @forelse($recentComplaints as $c)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between group hover:border-blue-200 transition">
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $c->title }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">By {{ $c->user->name ?? 'Resident' }} • {{ $c->category }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase border {{ $c->status === 'resolved' ? 'bg-emerald-100 border-emerald-200 text-emerald-700' : 'bg-amber-100 border-amber-200 text-amber-700' }}">
                            {{ $c->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm font-medium text-slate-500 bg-slate-50 p-4 rounded-xl border border-slate-100">No complaints filed yet.</p>
                @endforelse
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-extrabold text-slate-900">Gate Visitor Activity</h3>
                <a href="{{ route('visitors.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 hover:underline">View Desk &rarr;</a>
            </div>
            <div class="space-y-3">
                @forelse($recentVisitors as $v)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between group hover:border-blue-200 transition">
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $v->name }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Purpose: {{ $v->purpose }} • {{ $v->phone }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase border {{ $v->status === 'checked_in' ? 'bg-emerald-100 border-emerald-200 text-emerald-700' : 'bg-slate-100 border-slate-200 text-slate-600' }}">
                            {{ $v->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm font-medium text-slate-500 bg-slate-50 p-4 rounded-xl border border-slate-100">No visitor entries today.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
