@extends('layouts.app')

@section('title', 'Gate Security Desk')

@section('content')
<div class="space-y-6">

    <!-- Security Guard Header Banner -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-amber-900/70 via-yellow-950/70 to-slate-900 border border-amber-500/30 shadow-xl">
        <div class="flex items-center space-x-2 text-amber-400 text-xs font-bold uppercase tracking-wider mb-1">
            <span>👮 Gate Security Desk Operational Mode</span>
        </div>
        <h2 class="text-2xl font-extrabold text-white">Main Security Entry/Exit Desk</h2>
        <p class="text-sm text-amber-200/80 mt-1">Logged in as Security Officer. Authorized exclusively for visitor check-in, departure check-out, and vehicle gate verification.</p>
    </div>

    <!-- Security Desk Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Visitors Today</p>
            <h3 class="text-3xl font-extrabold text-amber-400 mt-2">{{ $stats['visitors_today'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">Total entries today</p>
        </div>

        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Currently Inside Premises</p>
            <h3 class="text-3xl font-extrabold text-emerald-400 mt-2">{{ $stats['currently_inside'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">Active visitors</p>
        </div>

        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Checked Out Today</p>
            {{-- <h3 class="text-3xl font-extrabold text-slate-300 mt-2">{{ $stats['checked_out_today'] }}</h3> --}}
            <p class="text-xs text-slate-500 mt-1">Completed visits</p>
        </div>
    </div>

    <!-- Quick Gate Desk Actions -->
    <div class="glass-card p-6 rounded-2xl border border-slate-800">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-white">Currently Checked-in Visitors</h3>
                <p class="text-xs text-slate-400">Manage gate departures and check-out logs.</p>
            </div>
            <a href="{{ route('visitors.index') }}" class="px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-500 text-white text-xs font-bold transition shadow-lg shadow-amber-600/30">
                Open Full Visitor Desk &rarr;
            </a>
        </div>

        <div class="space-y-3">
            @forelse($activeVisitors as $visitor)
                <div class="p-4 rounded-xl bg-slate-900/90 border border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="text-base font-bold text-white">{{ $visitor->name }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-500/20 text-emerald-300">INSIDE</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">Phone: {{ $visitor->phone }} | Vehicle: {{ $visitor->vehicle_number ?? 'N/A' }} | Purpose: {{ $visitor->purpose }}</p>
                        <p class="text-[10px] text-amber-400 mt-0.5">Check-in Time: {{ $visitor->check_in_time ? $visitor->check_in_time->format('h:i A') : $visitor->created_at->format('h:i A') }}</p>
                    </div>

                    <form action="{{ route('visitors.status.update', $visitor) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="checked_out">
                        <button type="submit" class="px-3.5 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold transition shadow-md">
                            Check-Out Visitor
                        </button>
                    </form>
                </div>
            @empty
                <div class="p-8 text-center bg-slate-900/40 rounded-xl border border-slate-800/80">
                    <p class="text-sm text-slate-400">No visitors currently inside the premises.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
