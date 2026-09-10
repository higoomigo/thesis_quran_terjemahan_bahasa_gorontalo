<!-- resources/views/components/alert.blade.php -->

<div class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none">
    
    <!-- SUCCESS MESSAGE -->
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" 
             x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-8"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-8"
             class="pointer-events-auto flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl shadow-lg min-w-[300px] max-w-md">
            <span class="material-symbols-outlined text-[24px] text-emerald-500">check_circle</span>
            <div class="flex-1">
                <h4 class="text-sm font-bold">Berhasil!</h4>
                <p class="text-xs font-medium text-emerald-600 mt-0.5">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 hover:bg-emerald-100 p-1 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-[18px] block">close</span>
            </button>
        </div>
    @endif

    <!-- ERROR MESSAGE (Dari session 'error') -->
    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-8"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-8"
             class="pointer-events-auto flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl shadow-lg min-w-[300px] max-w-md">
            <span class="material-symbols-outlined text-[24px] text-rose-500">error</span>
            <div class="flex-1">
                <h4 class="text-sm font-bold">Terjadi Kesalahan!</h4>
                <p class="text-xs font-medium text-rose-600 mt-0.5">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="text-rose-400 hover:text-rose-600 hover:bg-rose-100 p-1 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-[18px] block">close</span>
            </button>
        </div>
    @endif

    <!-- VALIDATION ERRORS (Bawaan Laravel dari Form) -->
    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-8"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-8"
             class="pointer-events-auto flex items-start gap-3 bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl shadow-lg min-w-[300px] max-w-md">
            <span class="material-symbols-outlined text-[24px] text-amber-500 mt-0.5">warning</span>
            <div class="flex-1">
                <h4 class="text-sm font-bold">Input Tidak Valid!</h4>
                <ul class="text-xs font-medium text-amber-600 mt-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button @click="show = false" class="text-amber-400 hover:text-amber-600 hover:bg-amber-100 p-1 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-[18px] block">close</span>
            </button>
        </div>
    @endif

</div>