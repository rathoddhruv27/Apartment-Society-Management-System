<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-100 text-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - ASMS Apartment Society Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 via-indigo-50/40 to-slate-200 flex items-center justify-center p-4 md:p-8">

    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl shadow-slate-300/60 border border-slate-200/80 overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[640px]">
        
        <!-- Left Side: Professional Society Showcase Banner -->
        <div class="lg:col-span-5 relative hidden lg:flex flex-col justify-between p-8 bg-slate-900 text-white overflow-hidden">
            <!-- Background Image with Soft Gradient Overlay -->
            <img src="{{ asset('images/society_complex.png') }}" alt="Residential Society Complex" class="absolute inset-0 w-full h-full object-cover object-center transform scale-105 transition duration-1000 hover:scale-100">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/60 to-slate-900/30"></div>

            <!-- Header Badge -->
            <div class="relative z-10 flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold tracking-tight text-white">ASMS Enterprise</h2>
                    <p class="text-xs text-indigo-200 font-medium">Smart Society Ecosystem</p>
                </div>
            </div>

            <!-- Bottom Content Box -->
            <div class="relative z-10 space-y-4">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl shadow-xl">
                    <span class="inline-block px-3 py-1 bg-indigo-500/80 backdrop-blur-sm text-white text-[11px] font-semibold tracking-wider uppercase rounded-full mb-3">Premium Living</span>
                    <h3 class="text-2xl font-extrabold text-white leading-tight mb-2">Empowering Modern Apartment Societies</h3>
                    <p class="text-xs text-slate-200 leading-relaxed">Streamlined operations, seamless visitor check-in, maintenance request tracking, and robust role-based access control.</p>
                </div>

                <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="bg-white/10 backdrop-blur-md border border-white/15 p-3 rounded-xl">
                        <p class="text-lg font-bold text-white">100%</p>
                        <p class="text-[10px] text-slate-300 uppercase font-semibold">Secure</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/15 p-3 rounded-xl">
                        <p class="text-lg font-bold text-white">4 Roles</p>
                        <p class="text-[10px] text-slate-300 uppercase font-semibold">RBAC Access</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/15 p-3 rounded-xl">
                        <p class="text-lg font-bold text-white">24/7</p>
                        <p class="text-[10px] text-slate-300 uppercase font-semibold">Gate Control</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form & Role Shortcuts -->
        <div class="lg:col-span-7 p-6 sm:p-10 flex flex-col justify-between bg-white">
            
            <div>
                <!-- Brand Header for Mobile / Tablet -->
                <div class="flex items-center space-x-3 mb-6 lg:hidden">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900">ASMS Portal</h1>
                        <p class="text-xs text-indigo-600 font-medium">Apartment Society Management</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Sign in to your account</h2>
                    <p class="text-sm text-slate-500 mt-1">Select a role or enter your credentials below to access your portal.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium flex items-center space-x-2">
                        <svg class="w-4 h-4 shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" required 
                                class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium focus:bg-white focus:outline-none focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 transition duration-150" 
                                placeholder="name@society.com">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                            <span class="text-xs text-indigo-600 hover:underline cursor-pointer font-medium">Forgot?</span>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" required 
                                class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium focus:bg-white focus:outline-none focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 transition duration-150" 
                                placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-lg shadow-indigo-600/25 transition duration-200 flex items-center justify-center space-x-2">
                        <span>Sign In to Dashboard</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>

                <!-- Quick Test Roles Section -->
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Demo Quick Access Roles</h3>
                        <span class="text-[11px] text-slate-400 font-medium">Click to fill</span>
                    </div>

                    <div class="grid grid-cols-2 gap-2.5">
                        <!-- Master Admin -->
                        <button type="button" onclick="fillForm('masteradmin@asms.com')" 
                            class="p-3 rounded-xl bg-purple-50/70 border border-purple-200/80 hover:bg-purple-100/90 text-left transition duration-150 group">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-purple-900 flex items-center space-x-1">
                                    <span>Master Admin</span>
                                </span>
                                <span class="text-[10px] text-purple-600 font-bold opacity-0 group-hover:opacity-100 transition">Fill →</span>
                            </div>
                            <p class="text-[11px] text-purple-700/80 mt-1 truncate">Full System & Permissions</p>
                        </button>

                        <!-- Society Admin -->
                        <button type="button" onclick="fillForm('admin@asms.com')" 
                            class="p-3 rounded-xl bg-blue-50/70 border border-blue-200/80 hover:bg-blue-100/90 text-left transition duration-150 group">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-blue-900 flex items-center space-x-1">
                                    <span>Society Admin</span>
                                </span>
                                <span class="text-[10px] text-blue-600 font-bold opacity-0 group-hover:opacity-100 transition">Fill →</span>
                            </div>
                            <p class="text-[11px] text-blue-700/80 mt-1 truncate">Society Users & Data</p>
                        </button>

                        <!-- Resident User -->
                        <button type="button" onclick="fillForm('user@asms.com')" 
                            class="p-3 rounded-xl bg-emerald-50/70 border border-emerald-200/80 hover:bg-emerald-100/90 text-left transition duration-150 group">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-emerald-900 flex items-center space-x-1">
                                    <span>Resident User</span>
                                </span>
                                <span class="text-[10px] text-emerald-600 font-bold opacity-0 group-hover:opacity-100 transition">Fill →</span>
                            </div>
                            <p class="text-[11px] text-emerald-700/80 mt-1 truncate">Complaints & Invites</p>
                        </button>

                        <!-- Security Guard -->
                        <button type="button" onclick="fillForm('guard@asms.com')" 
                            class="p-3 rounded-xl bg-amber-50/70 border border-amber-200/80 hover:bg-amber-100/90 text-left transition duration-150 group">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-amber-900 flex items-center space-x-1">
                                    <span>Security Guard</span>
                                </span>
                                <span class="text-[10px] text-amber-600 font-bold opacity-0 group-hover:opacity-100 transition">Fill →</span>
                            </div>
                            <p class="text-[11px] text-amber-700/80 mt-1 truncate">Visitor Logs & Check-in</p>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Apartment Society Management System &copy; 2026</span>
                <span>Default Pass: <code class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-700 font-mono font-semibold">password</code></span>
            </div>

        </div>

    </div>

    <script>
        function fillForm(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';
        }
    </script>
</body>
</html>
