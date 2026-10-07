@extends('layouts.app')

@section('title', 'Complaints & Support')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Society Complaints & Service Requests</h2>
            <p class="text-xs text-slate-500">File issues or track resolution progress across society maintenance departments.</p>
        </div>
    </div>

    <!-- Submit Complaint Form -->
    <div class="glass-card p-6 rounded-2xl border border-slate-200">
        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Submit New Ticket</h3>
        <form action="{{ route('complaints.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @csrf
            <div class="sm:col-span-2">
                <label class="block text-xs text-slate-500 mb-1">Subject Title</label>
                <input type="text" name="title" required class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-indigo-500" placeholder="e.g., Elevator malfunction in Block B">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Category</label>
                <select name="category" required class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-indigo-500">
                    <option value="Plumbing">Plumbing</option>
                    <option value="Electrical">Electrical</option>
                    <option value="Security">Security</option>
                    <option value="Elevator">Elevator</option>
                    <option value="Cleanliness">Cleanliness</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Priority</label>
                <select name="priority" required class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-indigo-500">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                    <option value="urgent">Urgent</option>
                </select>
            </div>

            <div class="sm:col-span-2 lg:col-span-4">
                <label class="block text-xs text-slate-500 mb-1">Detailed Description</label>
                <textarea name="description" rows="2" required class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs text-slate-900 focus:outline-none focus:border-indigo-500" placeholder="Provide full details of the issue..."></textarea>
            </div>

            <div class="sm:col-span-2 lg:col-span-4 flex justify-end">
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-slate-900 font-semibold text-xs transition shadow-lg shadow-indigo-600/30">
                    Submit Complaint Ticket
                </button>
            </div>
        </form>
    </div>

    <!-- Complaints Table -->
    <div class="glass-card rounded-2xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase border-b border-slate-200">
                    <tr>
                        <th class="p-4">Ticket</th>
                        <th class="p-4">Category & Priority</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($complaints as $c)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4">
                                <span class="font-semibold text-slate-900 block">{{ $c->title }}</span>
                                <span class="text-slate-500 text-[11px] block mt-0.5">{{ $c->description }}</span>
                                <span class="text-slate-500 text-[10px] block">By {{ $c->user->name ?? 'Resident' }} on {{ $c->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="p-4">
                                <div>{{ $c->category }}</div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $c->priority === 'urgent' ? 'bg-rose-100 text-rose-700 border border-rose-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                    {{ $c->priority }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase {{ $c->status === 'resolved' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-amber-100 text-amber-700 border border-amber-200' }}">
                                    {{ $c->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                @permission('manage-complaints')
                                    @if($c->status !== 'resolved')
                                        <form action="{{ route('complaints.update', $c) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="resolved">
                                            <button type="submit" class="px-3 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-slate-900 font-bold text-xs">
                                                Mark Resolved
                                            </button>
                                        </form>
                                    @endif
                                @endpermission
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-slate-500">No complaints filed.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200">
            {{ $complaints->links() }}
        </div>
    </div>

</div>
@endsection
