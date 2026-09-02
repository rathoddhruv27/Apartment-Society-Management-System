@extends('layouts.app')

@section('title', 'Role & Permission Matrix')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-white">System Roles & Permission Matrix</h2>
            <p class="text-xs text-slate-400">Configure role-based access control and module-level permissions.</p>
        </div>
    </div>

    <!-- Matrix Cards per Role -->
    <div class="grid grid-cols-1 gap-6">
        @foreach($roles as $role)
            <div class="glass-card p-6 rounded-2xl border border-slate-800">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b border-slate-800 pb-4">
                    <div>
                        <div class="flex items-center space-x-2">
                            <h3 class="text-lg font-bold text-white">{{ $role->name }}</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase bg-purple-500/20 text-purple-300">
                                {{ $role->slug }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">{{ $role->description }}</p>
                    </div>
                </div>

                <form action="{{ route('roles.permissions.update', $role) }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        @foreach($permissions as $module => $modulePermissions)
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-indigo-400 mb-3">{{ $module }} Module</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach($modulePermissions as $perm)
                                        @php
                                            $isChecked = $role->permissions->contains($perm->id);
                                        @endphp
                                        <label class="p-3 rounded-xl bg-slate-900/90 border border-slate-800 flex items-start space-x-3 cursor-pointer hover:border-slate-700 transition">
                                            <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" {{ $isChecked ? 'checked' : '' }} {{ $role->slug === 'master-admin' ? 'disabled' : '' }} class="mt-0.5 rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-indigo-500">
                                            <div>
                                                <span class="text-xs font-semibold text-white block">{{ $perm->name }}</span>
                                                <span class="text-[10px] text-slate-500 block">{{ $perm->description }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($role->slug !== 'master-admin')
                        <div class="mt-6 pt-4 border-t border-slate-800 flex justify-end">
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs transition shadow-lg shadow-indigo-600/30">
                                Save Permission Changes
                            </button>
                        </div>
                    @else
                        <p class="mt-4 text-xs text-purple-400 italic">* Master Admin automatically possesses full uninhibited permissions across all modules.</p>
                    @endif
                </form>
            </div>
        @endforeach
    </div>

</div>
@endsection
