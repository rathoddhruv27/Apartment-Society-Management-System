<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - ASMS Role-Based Access Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="h-full bg-slate-950 flex items-center justify-center p-4">

    <div class="w-full max-w-4xl grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">
        
        <!-- Left: Login Credentials Form -->
        <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl shadow-2xl flex flex-col justify-between">
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">ASMS Portal</h1>
                        <p class="text-xs text-indigo-400 font-medium">Role-Based Access Control</p>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-white mb-2">Welcome back</h2>
                <p class="text-sm text-slate-400 mb-6">Sign in to access your role-specific dashboard.</p>

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded-lg bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1">Email Address</label>
                        <input type="email" name="email" id="email" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition" placeholder="admin@asms.com">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1">Password</label>
                        <input type="password" name="password" id="password" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition" placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/30 transition duration-200">
                        Sign In
                    </button>
                </form>
            </div>
            
            <p class="text-xs text-slate-500 text-center mt-6">Apartment Society Management System &copy; 2026</p>
        </div>

        <!-- Right: Quick Demo Accounts for All 4 Roles -->
        <div class="bg-slate-900/60 border border-slate-800/80 p-8 rounded-2xl flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-white mb-1">Test Demo Roles</h3>
                <p class="text-xs text-slate-400 mb-6">Click any role below to prefill credentials for instant testing.</p>

                <div class="space-y-3">
                    <!-- Master Admin -->
                    <button onclick="fillForm('masteradmin@asms.com')" class="w-full p-3.5 rounded-xl bg-purple-950/40 border border-purple-800/40 hover:bg-purple-900/40 text-left transition flex items-center justify-between group">
                        <div>
                            <span class="inline-flex items-center text-xs font-bold text-purple-300">👑 Master Admin</span>
                            <p class="text-xs text-slate-400 mt-0.5">Full System & Permission Control</p>
                        </div>
                        <span class="text-xs text-purple-400 group-hover:translate-x-1 transition-transform">Use &rarr;</span>
                    </button>

                    <!-- Admin -->
                    <button onclick="fillForm('admin@asms.com')" class="w-full p-3.5 rounded-xl bg-blue-950/40 border border-blue-800/40 hover:bg-blue-900/40 text-left transition flex items-center justify-between group">
                        <div>
                            <span class="inline-flex items-center text-xs font-bold text-blue-300">🛡️ Society Admin</span>
                            <p class="text-xs text-slate-400 mt-0.5">Manage Users & Society Data</p>
                        </div>
                        <span class="text-xs text-blue-400 group-hover:translate-x-1 transition-transform">Use &rarr;</span>
                    </button>

                    <!-- Resident User -->
                    <button onclick="fillForm('user@asms.com')" class="w-full p-3.5 rounded-xl bg-emerald-950/40 border border-emerald-800/40 hover:bg-emerald-900/40 text-left transition flex items-center justify-between group">
                        <div>
                            <span class="inline-flex items-center text-xs font-bold text-emerald-300">🏠 Resident User</span>
                            <p class="text-xs text-slate-400 mt-0.5">Complaints, Vehicles & Visitor Invites</p>
                        </div>
                        <span class="text-xs text-emerald-400 group-hover:translate-x-1 transition-transform">Use &rarr;</span>
                    </button>

                    <!-- Security Guard -->
                    <button onclick="fillForm('guard@asms.com')" class="w-full p-3.5 rounded-xl bg-amber-950/40 border border-amber-800/40 hover:bg-amber-900/40 text-left transition flex items-center justify-between group">
                        <div>
                            <span class="inline-flex items-center text-xs font-bold text-amber-300">👮 Security Guard</span>
                            <p class="text-xs text-slate-400 mt-0.5">Gate Check-in/out & Visitor Log Only</p>
                        </div>
                        <span class="text-xs text-amber-400 group-hover:translate-x-1 transition-transform">Use &rarr;</span>
                    </button>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-800 text-xs text-slate-400">
                Default Password for all test roles: <code class="text-amber-400">password</code>
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
