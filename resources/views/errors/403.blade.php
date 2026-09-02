<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Access Denied</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="h-full bg-slate-950 flex items-center justify-center p-4">

    <div class="max-w-md w-full text-center p-8 rounded-3xl bg-slate-900 border border-slate-800 shadow-2xl">
        <div class="w-16 h-16 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-400 mx-auto flex items-center justify-center mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>

        <h1 class="text-4xl font-extrabold text-white mb-2">403</h1>
        <h2 class="text-lg font-bold text-slate-200 mb-2">Access Forbidden</h2>
        <p class="text-xs text-slate-400 mb-6">
            {{ $exception->getMessage() ?: 'You do not have the required role or permission to access this feature.' }}
        </p>

        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs transition shadow-lg shadow-indigo-600/30">
            &larr; Return to My Dashboard
        </a>
    </div>

</body>
</html>
