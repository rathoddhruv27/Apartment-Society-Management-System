@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Profile Header Banner Card -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-purple-950 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <!-- Avatar Display -->
            <div class="relative group">
                @if($user->avatar_url)
                    <img id="banner-avatar-preview" src="{{ $user->avatar_url }}" alt="{{ $user->full_name }}" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover ring-4 ring-white/20 shadow-lg">
                @else
                    <div id="banner-avatar-fallback" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 ring-4 ring-white/20 shadow-lg flex items-center justify-center text-3xl font-extrabold text-white">
                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ $user->second_name ? strtoupper(substr($user->second_name, 0, 1)) : '' }}
                    </div>
                    <img id="banner-avatar-preview" src="" alt="Avatar Preview" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover ring-4 ring-white/20 shadow-lg hidden">
                @endif
            </div>

            <div class="text-center sm:text-left flex-1">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-2">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">{{ $user->full_name }}</h1>
                    @role('master-admin')
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-500/30 text-purple-200 border border-purple-400/30">Master Admin</span>
                    @endrole
                    @role('admin')
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-500/30 text-blue-200 border border-blue-400/30">Property Manager</span>
                    @endrole
                    @role('user')
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/30 text-emerald-200 border border-emerald-400/30">Resident Member</span>
                    @endrole
                    @role('security-guard')
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/30 text-amber-200 border border-amber-400/30">Security Officer</span>
                    @endrole
                </div>
                <p class="text-sm text-indigo-200 font-medium">{{ $user->email }} • {{ $user->phone ?? 'No phone added' }}</p>
                <p class="text-xs text-slate-400 mt-2">Member since {{ $user->created_at ? $user->created_at->format('M Y') : 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Personal Information Form (2 Cols Wide) -->
        <div class="lg:col-span-2 glass-card p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900">Personal Information</h2>
                <p class="text-xs text-slate-500 mt-0.5">Update your account name, phone number, and avatar image.</p>
            </div>

            @if ($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Avatar Upload Section -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row items-center gap-4">
                    <div class="shrink-0">
                        @if($user->avatar_url)
                            <img id="form-avatar-preview" src="{{ $user->avatar_url }}" alt="Preview" class="w-16 h-16 rounded-full object-cover border border-slate-300 shadow-sm">
                        @else
                            <div id="form-avatar-placeholder" class="w-16 h-16 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-xl border border-indigo-200">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <img id="form-avatar-preview" src="" alt="Preview" class="w-16 h-16 rounded-full object-cover border border-slate-300 shadow-sm hidden">
                        @endif
                    </div>
                    <div class="flex-1 text-center sm:text-left min-w-0">
                        <label class="block text-xs font-bold text-slate-900 mb-1">Profile Photo (Avatar)</label>
                        <p class="text-[11px] text-slate-500 mb-2">Upload JPG, PNG, WEBP or GIF (max 2MB)</p>
                        <input type="file" name="avatar" id="avatar-input" accept="image/*" onchange="previewAvatar(event)" class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                    </div>
                </div>

                <!-- Name & Second Name -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">First Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm font-medium text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">2nd Name (Last Name)</label>
                        <input type="text" name="second_name" value="{{ old('second_name', $user->second_name) }}" placeholder="e.g. Smith" class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm font-medium text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                    </div>
                </div>

                <!-- Phone & Email -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 234 567 8900" class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm font-medium text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email Address <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm font-medium text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-lg shadow-indigo-600/30 transition">
                        Save Profile Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Column: Password Update & Summary -->
        <div class="space-y-6">

            <!-- Security / Password Update -->
            <div class="glass-card p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Change Password</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Ensure your account is using a strong password.</p>
                </div>

                <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Current Password</label>
                        <input type="password" name="current_password" required class="w-full px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-indigo-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">New Password</label>
                        <input type="password" name="password" required class="w-full px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-indigo-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required class="w-full px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-900 focus:outline-none focus:border-indigo-500 transition">
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-sm transition">
                        Update Password
                    </button>
                </form>
            </div>

            <!-- Account Details Card -->
            <div class="glass-card p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
                <h3 class="text-xs font-extrabold text-slate-500 uppercase tracking-wider">Account Information</h3>
                
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Assigned Role</span>
                        <span class="font-bold text-slate-900">{{ $user->role ? $user->role->name : 'Standard User' }}</span>
                    </div>

                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Account Status</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-100 text-emerald-700 border border-emerald-200">
                            {{ $user->status ?? 'active' }}
                        </span>
                    </div>

                    <div class="flex justify-between py-1.5">
                        <span class="text-slate-500 font-medium">User ID</span>
                        <span class="font-mono text-slate-700 font-semibold">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Update form preview
                const formPreview = document.getElementById('form-avatar-preview');
                const formPlaceholder = document.getElementById('form-avatar-placeholder');
                if (formPreview) {
                    formPreview.src = e.target.result;
                    formPreview.classList.remove('hidden');
                }
                if (formPlaceholder) {
                    formPlaceholder.classList.add('hidden');
                }

                // Update top banner preview
                const bannerPreview = document.getElementById('banner-avatar-preview');
                const bannerFallback = document.getElementById('banner-avatar-fallback');
                if (bannerPreview) {
                    bannerPreview.src = e.target.result;
                    bannerPreview.classList.remove('hidden');
                }
                if (bannerFallback) {
                    bannerFallback.classList.add('hidden');
                }
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
