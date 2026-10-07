@php
    // Auto-detect breadcrumbs based on route if not explicitly passed
    if (!isset($breadcrumbs) || !is_array($breadcrumbs)) {
        $breadcrumbs = [];
        $routeName = request()->route() ? request()->route()->getName() : '';

        if ($routeName === 'dashboard') {
            $breadcrumbs = [];
        } elseif (str_starts_with($routeName, 'users.')) {
            $breadcrumbs = [
                ['label' => 'User Management']
            ];
        } elseif (str_starts_with($routeName, 'buildings.')) {
            $breadcrumbs = [
                ['label' => 'Buildings & Apartments']
            ];
        } elseif (str_starts_with($routeName, 'roles.')) {
            $breadcrumbs = [
                ['label' => 'Roles & Permissions']
            ];
        } elseif (str_starts_with($routeName, 'visitors.')) {
            $breadcrumbs = [
                ['label' => 'Visitor Management']
            ];
        } elseif (str_starts_with($routeName, 'complaints.')) {
            $breadcrumbs = [
                ['label' => 'Complaints & Support']
            ];
        } elseif (str_starts_with($routeName, 'profile.')) {
            $breadcrumbs = [
                ['label' => 'My Profile']
            ];
        }
    }
@endphp

<nav class="flex text-xs font-medium text-slate-500 mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 sm:space-x-2">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-emerald-600 inline-flex items-center transition">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Home
            </a>
        </li>
        @foreach($breadcrumbs as $item)
            <li class="inline-flex items-center">
                <svg class="w-3.5 h-3.5 text-slate-300 mx-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                @if(isset($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="text-slate-500 hover:text-emerald-600 transition">{{ $item['label'] }}</a>
                @else
                    <span class="text-slate-800 font-bold">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
