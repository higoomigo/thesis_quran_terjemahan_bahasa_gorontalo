  <header class="flex justify-between items-center px-6 h-16 bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <div class="bg-gray-50 px-3 py-1.5 rounded-full border border-gray-200 flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 text-lg">search</span>
                    <input type="text" placeholder="Cari pesan..." class="bg-transparent border-none focus:ring-0 text-sm w-64" id="searchChat">
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="material-symbols-outlined text-gray-500 cursor-pointer hover:text-emerald-600">notifications</span>
                <span class="material-symbols-outlined text-gray-500 cursor-pointer hover:text-emerald-600">help</span>
                <div class="flex items-center gap-2 cursor-pointer">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 border-2 border-emerald-700 flex items-center justify-center text-emerald-800 font-bold text-xs">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                    </div>
                    <span class="font-bold text-emerald-800 text-sm">{{ Auth::user()->name ?? 'Validator' }}</span>
                </div>
            </div>
        </header>