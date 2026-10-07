@extends('layouts.app')

@section('title', 'Properties & Society Blocks')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-emerald-100/80 via-teal-50 to-emerald-50 border border-emerald-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Society Blocks & Residential Units</h2>
            <p class="text-sm text-slate-600 mt-1 font-medium">Directory of registered property blocks, total floors, and assigned apartment units.</p>
        </div>
        <button onclick="document.getElementById('add-building-modal').classList.remove('hidden')" class="px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-lg shadow-emerald-600/30 whitespace-nowrap inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Register New Block
        </button>
    </div>

    <!-- Buildings Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($buildings as $building)
            <div class="glass-card p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg border border-emerald-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-mono font-bold border border-slate-200">
                            CODE: {{ $building->code }}
                        </span>
                    </div>

                    <h3 class="text-xl font-extrabold text-slate-900 mt-4 truncate">{{ $building->name }}</h3>
                    
                    <div class="grid grid-cols-2 gap-2 mt-4 pt-4 border-t border-slate-100 text-xs">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-500 font-medium block">Total Floors</span>
                            <span class="text-lg font-bold text-slate-900">{{ $building->total_floors }}</span>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-500 font-medium block">Apartments</span>
                            <span class="text-lg font-bold text-emerald-600">{{ $building->apartments_count ?? 0 }} Units</span>
                        </div>
                    </div>
                </div>

                <!-- Actions: Edit & Delete -->
                <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('edit-building-modal-{{ $building->id }}').classList.remove('hidden')" class="px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition inline-flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Block
                    </button>

                    <button type="button" onclick="document.getElementById('delete-building-modal-{{ $building->id }}').classList.remove('hidden')" class="px-3.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs transition inline-flex items-center border border-rose-200/60">
                        <svg class="w-3.5 h-3.5 mr-1.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full p-12 text-center glass-card rounded-3xl border border-slate-200">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 mx-auto flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">No Property Blocks Registered Yet</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Start by registering building towers or blocks in your residential society.</p>
                <button onclick="document.getElementById('add-building-modal').classList.remove('hidden')" class="mt-4 px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-xs shadow-md">
                    + Add First Building Block
                </button>
            </div>
        @endforelse
    </div>

</div>
@endsection

@push('modals')
    <!-- Register New Building Modal -->
    <div id="add-building-modal" class="fixed inset-0 z-[100] bg-slate-900/40 backdrop-blur-xs flex items-start justify-center pt-6 sm:pt-10 p-4 hidden overflow-y-auto">
        <div class="glass-card w-full max-w-md p-6 sm:p-8 rounded-3xl bg-white shadow-2xl relative animate-in fade-in zoom-in duration-150">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-extrabold text-slate-900">Register New Building Block</h3>
                <button onclick="document.getElementById('add-building-modal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center font-bold text-sm">✕</button>
            </div>

            <form action="{{ route('buildings.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Building / Tower Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="e.g. Tower A - Emerald Heights" class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Building Code <span class="text-rose-500">*</span></label>
                    <input type="text" name="code" required placeholder="e.g. BLK-A" class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Total Floors <span class="text-rose-500">*</span></label>
                    <input type="number" name="total_floors" min="1" required placeholder="e.g. 12" class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20">
                </div>

                <div class="flex justify-end space-x-3 pt-3">
                    <button type="button" onclick="document.getElementById('add-building-modal').classList.add('hidden')" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/30 transition">Create Block</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit and Delete Modals per Building -->
    @foreach($buildings as $building)
        <!-- Edit Building Modal -->
        <div id="edit-building-modal-{{ $building->id }}" class="fixed inset-0 z-[100] bg-slate-900/40 backdrop-blur-xs flex items-start justify-center pt-6 sm:pt-10 p-4 hidden overflow-y-auto">
            <div class="glass-card w-full max-w-md p-6 sm:p-8 rounded-3xl bg-white shadow-2xl relative animate-in fade-in zoom-in duration-150">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-extrabold text-slate-900">Edit Building Block</h3>
                    <button type="button" onclick="document.getElementById('edit-building-modal-{{ $building->id }}').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center font-bold text-sm">✕</button>
                </div>

                <form action="{{ route('buildings.update', $building) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Building / Tower Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $building->name) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Building Code <span class="text-rose-500">*</span></label>
                        <input type="text" name="code" value="{{ old('code', $building->code) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Total Floors <span class="text-rose-500">*</span></label>
                        <input type="number" name="total_floors" value="{{ old('total_floors', $building->total_floors) }}" min="1" required class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20">
                    </div>

                    <div class="flex justify-end space-x-3 pt-3">
                        <button type="button" onclick="document.getElementById('edit-building-modal-{{ $building->id }}').classList.add('hidden')" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/30 transition">Update Block</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Building Confirmation Modal -->
        <div id="delete-building-modal-{{ $building->id }}" class="fixed inset-0 z-[100] bg-slate-900/40 backdrop-blur-xs flex items-start justify-center pt-6 sm:pt-10 p-4 hidden overflow-y-auto">
            <div class="glass-card w-full max-w-md p-6 sm:p-8 rounded-3xl bg-white shadow-2xl relative text-center animate-in fade-in zoom-in duration-150">
                <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 mx-auto flex items-center justify-center mb-4 border border-rose-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>

                <h3 class="text-xl font-extrabold text-slate-900">Delete Building Block</h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Are you sure you want to delete <strong class="text-slate-900 font-bold">"{{ $building->name }}"</strong>? This action cannot be undone and will remove the building block data.
                </p>

                <div class="flex items-center justify-center space-x-3 mt-6">
                    <button type="button" onclick="document.getElementById('delete-building-modal-{{ $building->id }}').classList.add('hidden')" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition">
                        Cancel
                    </button>
                    <form action="{{ route('buildings.destroy', $building) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-md shadow-rose-600/30 transition">
                            Yes, Delete Block
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endpush
