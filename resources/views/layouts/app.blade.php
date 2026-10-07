<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ASMS') }} - Role-Based Access Control</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">


    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(226, 232, 240, 0.8);
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
        .glass-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
    </style>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-slate-900/50 md:hidden" @click="sidebarOpen = false" x-transition.opacity style="display: none;"></div>

        <!-- Sidebar Navigation -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 glass-panel flex flex-col transition-transform duration-300 md:translate-x-0">
            <!-- App Brand Header -->
            <div class="h-16 px-6 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-purple-600 to-pink-500 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg text-slate-900 leading-tight">ASMS Web</h1>
                        <p class="text-xs text-indigo-600 font-medium">Society Management</p>
                    </div>
                </a>
            </div>

            <!-- Authenticated User Profile Summary -->
            @auth
            <div class="p-4 mx-4 my-4 rounded-xl bg-slate-100 border border-slate-200 flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center font-bold text-indigo-700 border border-indigo-200">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                    <div class="mt-0.5">
                        @role('master-admin')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 border border-purple-200">
                                Master Admin
                            </span>
                        @endrole
                        @role('admin')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                Admin
                            </span>
                        @endrole
                        @role('user')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                Resident User
                            </span>
                        @endrole
                        @role('security-guard')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">
                                Security Guard
                            </span>
                        @endrole
                    </div>
                </div>
            </div>
            @endauth

            <!-- Dynamic Role-Based Menu Items -->
            <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto">
                <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                    Main Navigation
                </div>

                <!-- Dashboard (All Roles) -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <!-- Master Admin Only: Roles & Permissions -->
                @role('master-admin')
                <a href="{{ route('roles.index') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('roles.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-600/30' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Roles & Permissions
                </a>
                @endrole

                <!-- Admin & Master Admin: User Management -->
                @role('master-admin,admin')
                <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    User Management
                </a>

                <a href="{{ route('buildings.index') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('buildings.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Buildings & Apartments
                </a>
                @endrole

                <!-- Visitor Log / Gate Desk (Security Guard, Admin, Master Admin & Resident Passes) -->
                @permission('view-visitors,view-own-visitors')
                <a href="{{ route('visitors.index') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('visitors.*') ? 'bg-amber-600 text-white shadow-lg shadow-amber-600/30' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
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

                <!-- Complaints Module -->
                @permission('view-complaints,view-own-complaints')
                <a href="{{ route('complaints.index') }}" class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('complaints.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Complaints & Support
                </a>
                @endpermission

            </nav>

            <!-- Bottom Dev Quick Role Switcher -->
            @role('master-admin')
            <div class="p-4 border-t border-slate-200 bg-slate-50" style="display: none !important;">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2 text-center">Quick Role Switcher</p>
                <form action="{{ route('switch-role') }}" method="POST" class="grid grid-cols-2 gap-1.5">
                    @csrf
                    <button type="submit" name="role_slug" value="master-admin" class="px-2 py-1.5 text-xs font-semibold rounded-lg bg-purple-100 hover:bg-purple-200 text-purple-700 border border-purple-200 transition">
                        Master
                    </button>
                    <button type="submit" name="role_slug" value="admin" class="px-2 py-1.5 text-xs font-semibold rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-700 border border-blue-200 transition">
                        Admin
                    </button>
                    <button type="submit" name="role_slug" value="user" class="px-2 py-1.5 text-xs font-semibold rounded-lg bg-emerald-100 hover:bg-emerald-200 text-emerald-700 border border-emerald-200 transition">
                        User
                    </button>
                    <button type="submit" name="role_slug" value="security-guard" class="px-2 py-1.5 text-xs font-semibold rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-700 border border-amber-200 transition">
                        Guard
                    </button>
                </form>
            </div>
            @endrole

            @auth
            <div class="p-4 border-t border-slate-200 mt-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-slate-300 text-sm font-semibold rounded-xl text-slate-700 bg-white hover:bg-rose-50 hover:text-rose-700 hover:border-rose-200 shadow-sm transition">
                        <svg class="w-5 h-5 mr-2 text-slate-400 group-hover:text-rose-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 bg-slate-50/50 md:pl-72 w-full">
            <!-- Top Header -->
            <header class="h-16 glass-header sticky top-0 flex items-center justify-between px-4 sm:px-6 z-30 shrink-0">
                <div class="flex items-center space-x-3">
                    <button @click="sidebarOpen = true" class="md:hidden p-2 -ml-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="text-lg font-bold text-slate-900">@yield('title', 'Dashboard')</h2>
                </div>
            </header>

            <!-- Main Scrollable Body -->
            <main class="flex-1 p-4 sm:p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center shadow-sm">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm flex items-center shadow-sm">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

    </div>

</body>
</html>
