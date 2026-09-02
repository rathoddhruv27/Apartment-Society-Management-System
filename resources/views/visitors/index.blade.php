@extends('layouts.app')

@section('title', 'Visitor Management')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-white">Visitor Entry & Gate Desk</h2>
            <p class="text-xs text-slate-400">Log guest arrivals, departure times, and pre-approved visitor passes.</p>
        </div>
    </div>

    <!-- Create Visitor Pass / Log Entry Form -->
    <div class="glass-card p-6 rounded-2xl border border-slate-800">
        <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">New Visitor Entry / Pre-approved Pass</h3>
        <form action="{{ route('visitors.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @csrf
            <div>
                <label class="block text-xs text-slate-400 mb-1">Visitor Name</label>
                <input type="text" name="name" required class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:outline-none focus:border-amber-500" placeholder="Visitor Name">
            </div>

            <div>
                <label class="block text-xs text-slate-400 mb-1">Phone Number</label>
                <input type="text" name="phone" required class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:outline-none focus:border-amber-500" placeholder="+19998887777">
            </div>

            <div>
                <label class="block text-xs text-slate-400 mb-1">Vehicle Number</label>
                <input type="text" name="vehicle_number" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:outline-none focus:border-amber-500" placeholder="ABC-1234">
            </div>

            <div>
                <label class="block text-xs text-slate-400 mb-1">Purpose of Visit</label>
                <input type="text" name="purpose" required class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-xs text-white focus:outline-none focus:border-amber-500" placeholder="Delivery / Guest">
            </div>

            <div class="sm:col-span-2 lg:col-span-4 flex justify-end">
                <button type="submit" class="px-5 py-2 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-semibold text-xs transition shadow-lg shadow-amber-600/30">
                    + Log Visitor / Create Pass
                </button>
            </div>
        </form>
    </div>

    <!-- Visitors Log Table -->
    <div class="glass-card rounded-2xl border border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-900/90 text-slate-400 font-bold uppercase border-b border-slate-800">
                    <tr>
                        <th class="p-4">Visitor</th>
                        <th class="p-4">Vehicle</th>
                        <th class="p-4">Purpose</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Timestamps</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($visitors as $v)
                        <tr class="hover:bg-slate-900/40">
                            <td class="p-4 font-semibold text-white">
                                {{ $v->name }}
                                <div class="text-slate-500 text-[10px]">{{ $v->phone }}</div>
                            </td>
                            <td class="p-4 text-slate-300">
                                {{ $v->vehicle_number ?? 'N/A' }}
                            </td>
                            <td class="p-4 text-slate-300">
                                {{ $v->purpose }}
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase {{ $v->status === 'checked_in' ? 'bg-emerald-500/20 text-emerald-300' : ($v->status === 'checked_out' ? 'bg-slate-800 text-slate-400' : 'bg-amber-500/20 text-amber-300') }}">
                                    {{ str_replace('_', ' ', $v->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-[10px] text-slate-400">
                                <div>In: {{ $v->check_in_time ? $v->check_in_time->format('M d, h:i A') : 'Not yet' }}</div>
                                <div>Out: {{ $v->check_out_time ? $v->check_out_time->format('M d, h:i A') : 'Not yet' }}</div>
                            </td>
                            <td class="p-4 text-right">
                                @permission('checkin-visitors,manage-visitors')
                                    @if($v->status !== 'checked_in' && $v->status !== 'checked_out')
                                        <form action="{{ route('visitors.status.update', $v) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="checked_in">
                                            <button type="submit" class="px-2.5 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-[10px] mr-1">
                                                Check In
                                            </button>
                                        </form>
                                    @endif

                                    @if($v->status === 'checked_in')
                                        <form action="{{ route('visitors.status.update', $v) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="checked_out">
                                            <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-600 hover:bg-rose-500 text-white font-bold text-[10px]">
                                                Check Out
                                            </button>
                                        </form>
                                    @endif
                                @endpermission
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-500">No visitor records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-800">
            {{ $visitors->links() }}
        </div>
    </div>

</div>
@endsection
