@extends('layouts.app')

@section('title', 'Resident Operational Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-emerald-100 via-teal-50 to-white border border-emerald-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-emerald-700 text-xs font-bold uppercase tracking-wider mb-1.5">
                <span>🏠 Society Resident Portal</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 mt-1">Welcome, {{ auth()->user()->name }}</h2>
            <p class="text-sm text-slate-600 mt-1 font-medium">Manage your flat details, family members, registered vehicles, complaints, and pre-approve gate visitor passes.</p>
        </div>
    </div>

    <!-- Resident Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">My Apartments</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-2">{{ $stats['my_apartments'] }}</h3>
            <p class="text-xs font-medium text-emerald-600 mt-1.5 bg-emerald-50 inline-block px-2 py-0.5 rounded-md">Assigned flats</p>
        </div>

        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Registered Vehicles</p>
            <h3 class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $stats['my_vehicles'] }}</h3>
            <p class="text-xs font-medium text-slate-600 mt-1.5">Sticker issued</p>
        </div>

        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Family Members</p>
            <h3 class="text-3xl font-extrabold text-teal-600 mt-2">{{ $stats['my_family'] }}</h3>
            <p class="text-xs font-medium text-slate-600 mt-1.5">Registered members</p>
        </div>

        <div class="glass-card p-6 rounded-2xl">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">My Complaints</p>
            <h3 class="text-3xl font-extrabold text-indigo-600 mt-2">{{ $stats['my_complaints'] }}</h3>
            <p class="text-xs font-medium text-slate-600 mt-1.5">Submitted tickets</p>
        </div>
    </div>

    <!-- Personal Lists -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-6 rounded-2xl">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-extrabold text-slate-900">My Filed Complaints</h3>
                <a href="{{ route('complaints.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline">+ File New</a>
            </div>
            <div class="space-y-3">
                @forelse($myComplaints as $c)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between group hover:border-emerald-200 transition">
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $c->title }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Category: {{ $c->category }} • Priority: {{ ucfirst($c->priority) }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase border {{ $c->status === 'resolved' ? 'bg-emerald-100 border-emerald-200 text-emerald-700' : 'bg-amber-100 border-amber-200 text-amber-700' }}">
                            {{ $c->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm font-medium text-slate-500 bg-slate-50 p-4 rounded-xl border border-slate-100">You have not submitted any complaints.</p>
                @endforelse
            </div>
        </div>

        <div class="glass-card p-6 rounded-2xl">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-extrabold text-slate-900">My Visitor Passes</h3>
                <a href="{{ route('visitors.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline">+ Pre-approve</a>
            </div>
            <div class="space-y-3">
                @forelse($myVisitors as $v)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between group hover:border-emerald-200 transition">
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $v->name }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Phone: {{ $v->phone }} • Purpose: {{ $v->purpose }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase border {{ $v->status === 'checked_in' ? 'bg-emerald-100 border-emerald-200 text-emerald-700' : 'bg-slate-100 border-slate-200 text-slate-600' }}">
                            {{ $v->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm font-medium text-slate-500 bg-slate-50 p-4 rounded-xl border border-slate-100">No active visitor passes created.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
