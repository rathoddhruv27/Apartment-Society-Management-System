{{-- =============================================
     TOP HEADER PARTIAL
     resources/views/partials/header.blade.php
     ============================================= --}}

<header class="h-16 glass-header sticky top-0 flex items-center justify-between px-4 sm:px-6 z-30 shrink-0">
    <div class="flex items-center space-x-3">
        {{-- Mobile Hamburger Button --}}
        <button @click="sidebarOpen = true" class="md:hidden p-2 -ml-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <h2 class="text-lg font-bold text-slate-900">@yield('title', 'Dashboard')</h2>
    </div>

    {{-- Header Profile & Logout Dropdown --}}
    @auth
    <div class="relative" x-data="{ userMenuOpen: false }">
        <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false" class="flex items-center space-x-3 p-1.5 rounded-2xl hover:bg-slate-100 transition focus:outline-none">
            <div class="shrink-0">
                @if(auth()->user()->avatar_url)
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->full_name }}" class="w-9 h-9 rounded-full object-cover ring-2 ring-indigo-500/20 shadow-sm">
                @else
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center font-bold text-white text-xs shadow-sm ring-2 ring-indigo-500/20">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ auth()->user()->second_name ? strtoupper(substr(auth()->user()->second_name, 0, 1)) : '' }}
                    </div>
                @endif
            </div>
            <div class="hidden sm:block text-left">
                <p class="text-xs font-bold text-slate-900 leading-tight">{{ auth()->user()->full_name }}</p>
                <p class="text-[10px] font-semibold text-indigo-600">
                    @role('master-admin') Master Admin @endrole
                    @role('admin') Property Manager @endrole
                    @role('user') Resident Member @endrole
                    @role('security-guard') Security Officer @endrole
                </p>
            </div>
            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="userMenuOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        {{-- User Dropdown Menu --}}
        <div x-show="userMenuOpen"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="absolute right-0 mt-2 w-64 glass-card rounded-2xl bg-white border border-slate-200/90 shadow-xl py-2 z-50 divide-y divide-slate-100"
             style="display: none;">

            {{-- User Info --}}
            <div class="px-4 py-3">
                <p class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->full_name }}</p>
                <p class="text-xs text-slate-500 truncate mt-0.5">{{ auth()->user()->email }}</p>
                <div class="mt-2">
                    @role('master-admin')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-purple-100 text-purple-700 border border-purple-200">Master Admin</span>
                    @endrole
                    @role('admin')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-100 text-blue-700 border border-blue-200">Property Manager</span>
                    @endrole
                    @role('user')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">Resident Member</span>
                    @endrole
                    @role('security-guard')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200">Security Officer</span>
                    @endrole
                </div>
            </div>

            {{-- Profile Link --}}
            <div class="py-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition">
                    <svg class="w-4 h-4 mr-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    My Profile & Settings
                </a>
            </div>

            {{-- Sign Out Link --}}
            <div class="py-1">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition">
                        <svg class="w-4 h-4 mr-2.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endauth
</header>
