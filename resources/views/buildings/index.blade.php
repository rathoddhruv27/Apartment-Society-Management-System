@extends('layouts.app')

@section('title', 'Properties & Society Blocks')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-purple-950 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-bold uppercase tracking-wider mb-2 border border-indigo-500/30">
                <span>Real Estate Management</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Society Blocks & Residential Units</h2>
            <p class="text-sm text-indigo-200 mt-1 font-medium">Directory of registered property blocks, total floors, and assigned apartment units.</p>
        </div>
        <button onclick="document.getElementById('add-building-modal').classList.remove('hidden')" class="px-5 py-3 rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white text-xs font-bold transition shadow-lg shadow-indigo-500/30 whitespace-nowrap inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            + Register New Block
        </button>
    </div>

    <!-- Buildings Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($buildings as $building)
            <div class="glass-card p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg border border-indigo-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-mono font-bold border border-slate-200">
                        CODE: {{ $building->code }}
                    </span>
                </div>

                <h3 class="text-xl font-extrabold text-slate-900 mt-4">{{ $building->name }}</h3>
                
                <div class="grid grid-cols-2 gap-2 mt-4 pt-4 border-t border-slate-100 text-xs">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-500 font-medium block">Total Floors</span>
                        <span class="text-lg font-bold text-slate-900">{{ $building->total_floors }}</span>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-500 font-medium block">Apartments</span>
                        <span class="text-lg font-bold text-indigo-600">{{ $building->apartments_count ?? 0 }} Units</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full p-12 text-center glass-card rounded-3xl border border-slate-200">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 mx-auto flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">No Property Blocks Registered Yet</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Start by registering building towers or blocks in your residential society.</p>
                <button onclick="document.getElementById('add-building-modal').classList.remove('hidden')" class="mt-4 px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-xs shadow-md">
                    + Add First Building Block
                </button>
            </div>
        @endforelse
    </div>

    <!-- Add Building Modal -->
    <div id="add-building-modal" class="fixed inset-0 z-50 bg-slate-900/50 flex items-center justify-center p-4 hidden">
        <div class="glass-card w-full max-w-md p-6 sm:p-8 rounded-3xl bg-white shadow-2xl relative">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-extrabold text-slate-900">Register New Building Block</h3>
                <button onclick="document.getElementById('add-building-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
            </div>

            <form action="{{ route('buildings.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Building / Tower Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="e.g. Tower A - Emerald Heights" class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Building Code <span class="text-rose-500">*</span></label>
                    <input type="text" name="code" required placeholder="e.g. BLK-A" class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Total Floors <span class="text-rose-500">*</span></label>
                    <input type="number" name="total_floors" min="1" required placeholder="e.g. 12" class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-indigo-500">
                </div>

                <div class="flex justify-end space-x-3 pt-3">
                    <button type="button" onclick="document.getElementById('add-building-modal').classList.add('hidden')" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md">Create Block</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
