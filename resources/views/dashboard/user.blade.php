@extends('layouts.app')

@section('title', 'Resident Operational Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-emerald-900/60 via-teal-900/60 to-slate-900 border border-emerald-500/30 shadow-xl">
        <span class="text-emerald-400 text-xs font-bold uppercase tracking-wider">🏠 Society Resident Portal</span>
        <h2 class="text-2xl font-extrabold text-white mt-1">Welcome, {{ auth()->user()->name }}</h2>
        <p class="text-sm text-emerald-200/80 mt-1">Manage your flat details, family members, registered vehicles, complaints, and pre-approve gate visitor passes.</p>
    </div>

    <!-- Resident Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">My Apartments</p>
            <h3 class="text-3xl font-extrabold text-white mt-2">{{ $stats['my_apartments'] }}</h3>
            <p class="text-xs text-emerald-400 mt-1">Assigned flats</p>
        </div>

        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Registered Vehicles</p>
            <h3 class="text-3xl font-extrabold text-emerald-400 mt-2">{{ $stats['my_vehicles'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">Sticker issued</p>
        </div>

        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Family Members</p>
            <h3 class="text-3xl font-extrabold text-teal-400 mt-2">{{ $stats['my_family'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">Registered members</p>
        </div>

        <div class="glass-card p-5 rounded-2xl border border-slate-800">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">My Complaints</p>
            <h3 class="text-3xl font-extrabold text-indigo-400 mt-2">{{ $stats['my_complaints'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">Submitted tickets</p>
        </div>
    </div>

    <!-- Personal Lists -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-6 rounded-2xl border border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white">My Filed Complaints</h3>
                <a href="{{ route('complaints.index') }}" class="text-xs font-semibold text-emerald-400 hover:underline">+ File New Complaint</a>
            </div>
            <div class="space-y-3">
                @forelse($myComplaints as $c)
                    <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-white">{{ $c->title }}</p>
                            <p class="text-xs text-slate-400">Category: {{ $c->category }} • Priority: {{ ucfirst($c->priority) }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase {{ $c->status === 'resolved' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-amber-500/20 text-amber-300' }}">
                            {{ $c->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">You have not submitted any complaints.</p>
                @endforelse
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl border border-slate-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white">My Visitor Passes</h3>
                <a href="{{ route('visitors.index') }}" class="text-xs font-semibold text-emerald-400 hover:underline">+ Pre-approve Visitor</a>
            </div>
            <div class="space-y-3">
                @forelse($myVisitors as $v)
                    <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-white">{{ $v->name }}</p>
                            <p class="text-xs text-slate-400">Phone: {{ $v->phone }} • Purpose: {{ $v->purpose }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase {{ $v->status === 'checked_in' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-slate-800 text-slate-400' }}">
                            {{ $v->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No active visitor passes created.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
