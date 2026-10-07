@extends('layouts.app')

@section('title', 'Gate Security Desk')

@section('content')
<div class="space-y-6">

    <!-- Security Guard Header Banner -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-amber-100 via-yellow-50 to-white border border-amber-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-amber-700 text-xs font-bold uppercase tracking-wider mb-1.5">
                <span>Gate Security Desk Operational Mode</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 mt-1">Main Security Entry/Exit Desk</h2>
            <p class="text-sm text-slate-600 mt-1 font-medium">Logged in as Security Officer. Authorized exclusively for visitor check-in, departure check-out, and vehicle gate verification.</p>
        </div>
    </div>

    <!-- Security Desk Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6">
        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Visitors Today</p>
            <h3 class="text-3xl font-extrabold text-amber-600 mt-2">{{ $stats['visitors_today'] }}</h3>
            <p class="text-xs font-medium text-slate-600 mt-1.5 bg-amber-50 inline-block px-2 py-0.5 rounded-md">Total entries today</p>
        </div>

        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Currently Inside Premises</p>
            <h3 class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $stats['currently_inside'] }}</h3>
            <p class="text-xs font-medium text-slate-600 mt-1.5">Active visitors</p>
        </div>

        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Completed Visits</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-2">--</h3>
            <p class="text-xs font-medium text-slate-600 mt-1.5">Logged out today</p>
        </div>
    </div>

    <!-- Quick Gate Desk Actions -->
    <div class="glass-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-lg font-extrabold text-slate-900">Currently Checked-in Visitors</h3>
                <p class="text-xs font-medium text-slate-500 mt-0.5">Manage gate departures and check-out logs.</p>
            </div>
            <a href="{{ route('visitors.index') }}" class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition shadow-lg shadow-amber-500/25 whitespace-nowrap">
                Open Visitor Desk &rarr;
            </a>
        </div>

        <div class="space-y-3">
            @forelse($activeVisitors as $visitor)
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-amber-200 transition">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="text-base font-bold text-slate-900">{{ $visitor->name }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-100 border border-emerald-200 text-emerald-700">INSIDE</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium mt-1">Phone: {{ $visitor->phone }} | Vehicle: {{ $visitor->vehicle_number ?? 'N/A' }} | Purpose: {{ $visitor->purpose }}</p>
                        <p class="text-[10px] font-bold text-amber-700 mt-1">Check-in Time: {{ $visitor->check_in_time ? $visitor->check_in_time->format('h:i A') : $visitor->created_at->format('h:i A') }}</p>
                    </div>

                    <form action="{{ route('visitors.status.update', $visitor) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="checked_out">
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold transition shadow-sm whitespace-nowrap">
                            Check-Out Visitor
                        </button>
                    </form>
                </div>
            @empty
                <div class="p-6 text-center bg-slate-50 rounded-xl border border-slate-100">
                    <p class="text-sm font-medium text-slate-500">No visitors currently inside the premises.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
