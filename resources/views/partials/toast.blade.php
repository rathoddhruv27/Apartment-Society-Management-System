<!-- Global Common Toast Notification System with Timers -->
<div class="fixed top-5 right-5 z-[120] flex flex-col space-y-3 max-w-sm w-full pointer-events-none px-4 sm:px-0">

    {{-- Success Toast --}}
    @if(session('success'))
        <div x-data="{ show: true, progress: 100 }" 
             x-init="
                let duration = 2000;
                let step = 50;
                let timer = setInterval(() => {
                    progress -= (step / duration) * 100;
                    if (progress <= 0) {
                        clearInterval(timer);
                        show = false;
                    }
                }, step);
             "
             x-show="show"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="pointer-events-auto bg-white rounded-2xl shadow-xl border border-emerald-100 p-4 relative overflow-hidden flex items-start space-x-3 group">
            
            <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200/60">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <div class="flex-1 min-w-0 pt-0.5">
                <h4 class="text-xs font-bold text-slate-900">Success</h4>
                <p class="text-xs text-slate-600 mt-0.5 font-medium leading-relaxed">{{ session('success') }}</p>
            </div>

            <button @click="show = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg transition focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Bottom Shrinking Timer Line -->
            <div class="absolute bottom-0 left-0 h-1 bg-emerald-500 transition-all duration-75 ease-linear" :style="`width: ${progress}%`"></div>
        </div>
    @endif

    {{-- Error Toast --}}
    @if(session('error'))
        <div x-data="{ show: true, progress: 100 }" 
             x-init="
                let duration = 2000;
                let step = 50;
                let timer = setInterval(() => {
                    progress -= (step / duration) * 100;
                    if (progress <= 0) {
                        clearInterval(timer);
                        show = false;
                    }
                }, step);
             "
             x-show="show"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="pointer-events-auto bg-white rounded-2xl shadow-xl border border-rose-100 p-4 relative overflow-hidden flex items-start space-x-3 group">
            
            <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 border border-rose-200/60">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <div class="flex-1 min-w-0 pt-0.5">
                <h4 class="text-xs font-bold text-slate-900">Error</h4>
                <p class="text-xs text-slate-600 mt-0.5 font-medium leading-relaxed">{{ session('error') }}</p>
            </div>

            <button @click="show = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg transition focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Bottom Shrinking Timer Line -->
            <div class="absolute bottom-0 left-0 h-1 bg-rose-500 transition-all duration-75 ease-linear" :style="`width: ${progress}%`"></div>
        </div>
    @endif

    {{-- Info Toast --}}
    @if(session('info'))
        <div x-data="{ show: true, progress: 100 }" 
             x-init="
                let duration = 2000;
                let step = 50;
                let timer = setInterval(() => {
                    progress -= (step / duration) * 100;
                    if (progress <= 0) {
                        clearInterval(timer);
                        show = false;
                    }
                }, step);
             "
             x-show="show"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="pointer-events-auto bg-white rounded-2xl shadow-xl border border-sky-100 p-4 relative overflow-hidden flex items-start space-x-3 group">
            
            <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 border border-sky-200/60">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <div class="flex-1 min-w-0 pt-0.5">
                <h4 class="text-xs font-bold text-slate-900">Information</h4>
                <p class="text-xs text-slate-600 mt-0.5 font-medium leading-relaxed">{{ session('info') }}</p>
            </div>

            <button @click="show = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg transition focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Bottom Shrinking Timer Line -->
            <div class="absolute bottom-0 left-0 h-1 bg-sky-500 transition-all duration-75 ease-linear" :style="`width: ${progress}%`"></div>
        </div>
    @endif

</div>
