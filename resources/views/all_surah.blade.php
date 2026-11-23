<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Qur'an Gorontalo - Mushaf</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Noto+Serif:wght@400&amp;display=swap" rel="stylesheet" />
    @include('partials.pwa')
    
    <style>
        .pattern-bg {
            background-image: radial-gradient(var(--tw-colors-primary-container) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.03;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background text-on-background min-h-screen font-body-reading-translation relative">
    <!-- Background Pattern -->
    <div class="fixed inset-0 pattern-bg pointer-events-none z-0"></div>
    
    <!-- TopNavBar -->
    @include('partials.navbar')
    
    <!-- Main Canvas -->
    <main class="relative z-10 max-w-container-max mx-auto px-4 md:px-8 pt-8 pb-24">
        
        <!-- Header & Tabs Section -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-8 border-b border-surface-variant pb-4">
            
            <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                <h2 class=" text-3xl font-semibold text-primary inline-block">
                    Mamongadi
                </h2>
                
                <!-- TABS TOGGLE -->
                <div class="flex p-1 bg-surface-variant rounded-xl w-full sm:w-auto">
                    <button id="tabSurah" class="flex-1 sm:flex-none px-8 py-2.5 rounded-lg font-label-md text-sm font-bold bg-white shadow-sm text-primary transition-all">
                        Surah
                    </button>
                    <button id="tabJuz" class="flex-1 sm:flex-none px-8 py-2.5 rounded-lg font-label-md text-sm font-bold text-on-surface-variant hover:text-primary transition-all">
                        Juz
                    </button>
                </div>
            </div>
            
            <!-- Filters & Search (Hanya Tampil di Tab Surah) -->
            <div id="filterContainer" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto transition-opacity duration-300">
                <!-- Dropdown Juz (Filter Surah) -->
                {{-- <div class="relative w-full sm:w-40 flex-shrink-0">
                    <select id="juzFilter" class="w-full pl-4 pr-8 py-2.5 bg-surface rounded-full border border-outline-variant text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-label-md text-sm appearance-none cursor-pointer">
                        <option value="">Semua Juz</option>
                        @for($i = 1; $i <= 30; $i++)
                            <option value="{{ $i }}">Juz {{ $i }}</option>
                        @endfor
                    </select>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-outline text-lg">expand_more</span>
                    </div>
                </div> --}}

                <!-- Search Input -->
                <div class="relative w-full sm:w-72 lg:w-80">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-outline text-sm" data-icon="search">search</span>
                    </div>
                    <input id="searchSurahInput" 
                           class="w-full pl-9 pr-10 py-2.5 bg-surface rounded-full border border-outline-variant text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-label-md text-sm"
                           placeholder="Cari surah..." 
                           type="text" 
                           autocomplete="off" />
                    <div id="searchClearBtn" class="absolute inset-y-0 right-3 flex items-center cursor-pointer hidden">
                        <span class="material-symbols-outlined text-outline text-sm hover:text-primary transition-colors">close</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== TAB CONTENT: SURAH ==================== -->
        <div id="surahListContainer" class="transition-opacity duration-300">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6" id="surahList">
                @foreach ($surahs as $surah)
                @php
                    $juzArray = $surah->ayats->pluck('juz')->unique()->filter()->sort()->values()->toArray();
                    $juzString = implode(',', $juzArray);
                    $juzLabel = count($juzArray) > 1 ? 'Juz ' . min($juzArray) . ' - ' . max($juzArray) : (count($juzArray) == 1 ? 'Juz ' . $juzArray[0] : '');
                @endphp

                <a href="{{ route('surah.show', $surah->no_surah) }}" 
                   class="surah-item block bg-surface rounded-2xl border border-outline-variant p-5 hover:border-primary hover:shadow-md hover:bg-surface-container-low hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden"
                   data-surah-name="{{ strtolower($surah->nama_latin) }}"
                   data-surah-arti="{{ strtolower($surah->arti) }}"
                   data-surah-number="{{ $surah->no_surah }}"
                   data-surah-juz="{{ $juzString }}">
                   
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex gap-3 items-center">
                            <div class="w-10 h-10 rounded-full bg-primary-fixed/30 flex items-center justify-center flex-shrink-0 group-hover:bg-primary transition-colors duration-300">
                                <span class="font-label-md text-primary font-bold group-hover:text-on-primary transition-colors duration-300">{{ $surah->no_surah }}</span>
                            </div>
                            {{-- @if($juzLabel)
                            <div class="px-2 py-1 rounded-md bg-surface-variant text-on-surface-variant font-caption text-xs font-semibold group-hover:bg-primary-fixed group-hover:text-on-primary-fixed transition-colors">
                                {{ $juzLabel }}
                            </div>
                            @endif --}}
                        </div>
                        <div class="text-right flex-shrink-0 ml-2">
                            <span class="font-body-reading-arabic text-2xl text-primary">{{ $surah->arabic_name }}</span>
                        </div>
                    </div>

                    <div class="mt-2">
                        <h3 class="font-headline-lg text-lg font-bold text-on-surface group-hover:text-primary transition-colors duration-300">{{ $surah->nama_latin }}</h3>
                        <p class="font-caption text-sm text-on-surface-variant mt-1">{{ $surah->arti }}</p>
                    </div>
                </a>
                @endforeach
            </div>
            
            <!-- Fallback Search Kosong -->
            <div id="noResults" class="text-center py-16 hidden col-span-full">
                <span class="material-symbols-outlined text-5xl text-outline mb-3 block opacity-50">search_off</span>
                <p class="text-on-surface font-semibold text-lg">Tidak ada surah yang ditemukan</p>
                <p class="text-sm text-on-surface-variant mt-1">Coba sesuaikan kata pencarian atau filter juz Anda.</p>
                <button id="resetFilterBtn" class="mt-4 px-4 py-2 bg-primary-fixed text-on-primary-fixed rounded-full font-label-md text-sm hover:bg-primary-fixed-dim transition-colors">
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- ==================== TAB CONTENT: JUZ ==================== -->
        <!-- ==================== TAB CONTENT: JUZ ==================== -->
        <!-- ==================== TAB CONTENT: JUZ ==================== -->
        <div id="juzListContainer" class="hidden transition-opacity duration-300">
            <div class="grid grid-cols-1 gap-3 md:gap-4 max-w-4xl mx-auto">
                
                @foreach($juzData as $juz)
                    <a href="{{ route('juz.show', $juz->id) }}" 
                       class="flex items-center gap-4 bg-surface rounded-xl border border-outline-variant p-3 md:p-4 hover:border-primary hover:shadow-md hover:bg-surface-container-low hover:translate-x-1 transition-all duration-300 group">
                        
                        <div class="w-12 h-12 flex-shrink-0 rounded-full bg-primary-fixed/30 flex items-center justify-center group-hover:bg-primary transition-colors duration-300">
                            <span class="font-headline-lg text-lg text-primary font-bold group-hover:text-white transition-colors duration-300">
                                {{ $juz->id }}
                            </span>
                        </div>
                        
                        <!-- Area Teks -->
                        <div class="flex flex-col">
                            <h3 class="font-label-md text-base md:text-lg font-bold text-on-surface group-hover:text-primary transition-colors duration-300">
                                Juz {{ $juz->id }}
                            </h3>
                            <p class="text-xs md:text-sm text-outline mt-0.5">
                                {{ $juz->keterangan }}
                            </p>
                        </div>

                        <div class="ml-auto text-outline opacity-50 group-hover:text-primary group-hover:opacity-100 transition-all duration-300">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </div>
                    </a>
                @endforeach
                
            </div>
        </div>

    </main>
    
    <!-- Footer -->
    @include('partials.footer')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- LOGIKA TAB SWITCHER ---
        const tabSurah = document.getElementById('tabSurah');
        const tabJuz = document.getElementById('tabJuz');
        const surahListContainer = document.getElementById('surahListContainer');
        const juzListContainer = document.getElementById('juzListContainer');
        const filterContainer = document.getElementById('filterContainer');

        function activateTab(tabName) {
            if (tabName === 'surah') {
                // Style Aktif Tab Surah
                tabSurah.classList.add('bg-white', 'shadow-sm', 'text-primary');
                tabSurah.classList.remove('text-on-surface-variant', 'hover:text-primary');
                // Style Mati Tab Juz
                tabJuz.classList.remove('bg-white', 'shadow-sm', 'text-primary');
                tabJuz.classList.add('text-on-surface-variant', 'hover:text-primary');
                
                // Toggle Konten
                surahListContainer.classList.remove('hidden');
                filterContainer.classList.remove('hidden');
                juzListContainer.classList.add('hidden');
            } else {
                // Style Aktif Tab Juz
                tabJuz.classList.add('bg-white', 'shadow-sm', 'text-primary');
                tabJuz.classList.remove('text-on-surface-variant', 'hover:text-primary');
                // Style Mati Tab Surah
                tabSurah.classList.remove('bg-white', 'shadow-sm', 'text-primary');
                tabSurah.classList.add('text-on-surface-variant', 'hover:text-primary');
                
                // Toggle Konten
                juzListContainer.classList.remove('hidden');
                surahListContainer.classList.add('hidden');
                filterContainer.classList.add('hidden'); // Sembunyikan pencarian di mode Juz
            }
        }

        tabSurah.addEventListener('click', () => activateTab('surah'));
        tabJuz.addEventListener('click', () => activateTab('juz'));


        // --- LOGIKA FILTER PENCARIAN & JUZ (SURAH TAB) ---
        const searchInput = document.getElementById('searchSurahInput');
        const searchClearBtn = document.getElementById('searchClearBtn');
        const juzFilter = document.getElementById('juzFilter');
        const noResults = document.getElementById('noResults');
        const resetFilterBtn = document.getElementById('resetFilterBtn');
        let searchTimeout;
        
        function filterSurahs() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const selectedJuz = juzFilter.value; 
            const surahItems = document.querySelectorAll('.surah-item');
            let hasResults = false;
            
            surahItems.forEach(item => {
                const surahName = item.getAttribute('data-surah-name');
                const surahArti = item.getAttribute('data-surah-arti');
                const surahNumber = item.getAttribute('data-surah-number');
                const surahJuzArray = item.getAttribute('data-surah-juz').split(','); 
                
                const matchesSearch = searchTerm === '' || 
                                      surahName.includes(searchTerm) || 
                                      surahArti.includes(searchTerm) || 
                                      surahNumber === searchTerm;
                                      
                const matchesJuz = selectedJuz === '' || surahJuzArray.includes(selectedJuz);
                
                if (matchesSearch && matchesJuz) {
                    item.style.display = 'block';
                    hasResults = true;
                } else {
                    item.style.display = 'none';
                }
            });
            
            if (!hasResults) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }
        
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(filterSurahs, 300);
            
            if (this.value.length > 0) {
                searchClearBtn.classList.remove('hidden');
            } else {
                searchClearBtn.classList.add('hidden');
            }
        });
        
        juzFilter.addEventListener('change', filterSurahs);
        
        searchClearBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchClearBtn.classList.add('hidden');
            filterSurahs();
            searchInput.focus();
        });

        resetFilterBtn.addEventListener('click', function() {
            searchInput.value = '';
            juzFilter.value = '';
            searchClearBtn.classList.add('hidden');
            filterSurahs();
        });
        
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                activateTab('surah'); // Otomatis pindah tab Surah kalau pencet Ctrl+K
                searchInput.focus();
            }
        });
    });
    </script>
</body>
</html>