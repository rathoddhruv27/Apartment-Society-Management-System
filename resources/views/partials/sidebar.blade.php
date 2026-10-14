{{-- =============================================
     SIDEBAR NAVIGATION PARTIAL
     resources/views/partials/sidebar.blade.php
     ============================================= --}}

{{-- Mobile Sidebar Overlay --}}
<div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-slate-900/50 md:hidden" @click="sidebarOpen = false" x-transition.opacity style="display: none;"></div>

{{-- Sidebar Navigation --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 glass-panel flex flex-col transition-transform duration-300 md:translate-x-0">

    {{-- App Brand Header --}}
    <div class="h-16 px-6 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-purple-600 to-pink-500 flex items-center justify-center shadow-lg shadow-indigo-500/20 p-1.5 overflow-hidden">
                <img src="{{ asset('images/favicon.png') }}" alt="ASMS Logo" class="w-full h-full object-contain brightness-0 invert">
            </div>
            <div>
                <h1 class="font-bold text-lg text-slate-900 leading-tight">ASMS Web</h1>
                <p class="text-xs text-indigo-600 font-medium">Society Management</p>
            </div>
        </a>
    </div>

    {{-- Dynamic Role-Based Menu Items --}}
    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">
            Main Portal
        </div>

        {{-- Dashboard (All Roles) --}}
        <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'text-white shadow-lg' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}" @if(request()->routeIs('dashboard')) style="background-color:#4F46E5;box-shadow:0 10px 15px -3px rgba(79,70,229,0.3)" @endif>
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        {{-- Master Admin Only: Roles & Permissions --}}
        @role('master-admin')
        <a href="{{ route('roles.index') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('roles.*') ? 'text-white shadow-lg' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}" @if(request()->routeIs('roles.*')) style="background-color:#4F46E5;box-shadow:0 10px 15px -3px rgba(79,70,229,0.3)" @endif>
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            Roles & Permissions
        </a>
        @endrole

        {{-- Admin & Master Admin: User Management --}}
        @role('master-admin,admin')
        <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('users.*') ? 'text-white shadow-lg' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}" @if(request()->routeIs('users.*')) style="background-color:#4F46E5;box-shadow:0 10px 15px -3px rgba(79,70,229,0.3)" @endif>
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            User Management
        </a>

        <a href="{{ route('buildings.index') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('buildings.*') ? 'text-white shadow-lg' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}" @if(request()->routeIs('buildings.*')) style="background-color:#4F46E5;box-shadow:0 10px 15px -3px rgba(79,70,229,0.3)" @endif>
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            Buildings & Apartments
        </a>
        @endrole

        {{-- Visitor Log / Gate Desk --}}
        @permission('view-visitors,view-own-visitors')
        <a href="{{ route('visitors.index') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('visitors.*') ? 'text-white shadow-lg' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}" @if(request()->routeIs('visitors.*')) style="background-color:#4F46E5;box-shadow:0 10px 15px -3px rgba(79,70,229,0.3)" @endif>
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            @role('security-guard')
                Gate Security Log
            @else
                Visitor Management
            @endrole
        </a>
        @endpermission

        {{-- Complaints Module --}}
        @permission('view-complaints,view-own-complaints')
        <a href="{{ route('complaints.index') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('complaints.*') ? 'text-white shadow-lg' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}" @if(request()->routeIs('complaints.*')) style="background-color:#4F46E5;box-shadow:0 10px 15px -3px rgba(79,70,229,0.3)" @endif>
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Complaints & Support
        </a>
        @endpermission

    </nav>
</aside>
