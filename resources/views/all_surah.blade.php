<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Qur'an Gorontalo - Mushaf</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Noto+Serif:wght@400&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-fixed": "#a6f2d1",
                        "surface": "#f9f9ff",
                        "on-tertiary-container": "#a8d0bc",
                        "on-secondary-fixed": "#331200",
                        "tertiary": "#1e4334",
                        "surface-bright": "#f9f9ff",
                        "secondary-container": "#fd8a42",
                        "error": "#ba1a1a",
                        "tertiary-container": "#365a4a",
                        "surface-tint": "#1b6b51",
                        "on-tertiary-fixed": "#002115",
                        "primary-fixed-dim": "#8bd6b6",
                        "on-primary-fixed": "#002116",
                        "inverse-surface": "#2a313d",
                        "on-primary-container": "#8bd6b7",
                        "on-background": "#151c27",
                        "background": "#f9f9ff",
                        "tertiary-fixed-dim": "#a8cfbc",
                        "secondary": "#9b4500",
                        "on-primary": "#ffffff",
                        "surface-container-low": "#f0f3ff",
                        "inverse-primary": "#8bd6b6",
                        "on-secondary-container": "#682c00",
                        "on-surface": "#151c27",
                        "primary-container": "#065f46",
                        "on-tertiary": "#ffffff",
                        "error-container": "#ffdad6",
                        "surface-container-lowest": "#ffffff",
                        "on-surface-variant": "#3f4944",
                        "primary": "#004532",
                        "surface-container-high": "#e2e8f8",
                        "secondary-fixed": "#ffdbca",
                        "on-error-container": "#93000a",
                        "surface-container-highest": "#dce2f3",
                        "on-secondary-fixed-variant": "#763300",
                        "outline": "#6f7973",
                        "on-primary-fixed-variant": "#00513b",
                        "on-secondary": "#ffffff",
                        "on-error": "#ffffff",
                        "tertiary-fixed": "#c3ecd7",
                        "surface-dim": "#d3daea",
                        "surface-container": "#e7eefe",
                        "inverse-on-surface": "#ebf1ff",
                        "outline-variant": "#bec9c2",
                        "surface-variant": "#dce2f3",
                        "secondary-fixed-dim": "#ffb68e",
                        "on-tertiary-fixed-variant": "#294e3f"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "md": "1rem",
                        "gutter": "1.5rem",
                        "lg": "1.5rem",
                        "xl": "2.5rem",
                        "xs": "0.25rem",
                        "container-max": "1200px",
                        "sm": "0.5rem",
                        "unit": "4px"
                    },
                    "fontFamily": {
                        "label-md": ["Inter"],
                        "caption": ["Inter"],
                        "headline-lg": ["Inter"],
                        "headline-xl": ["Inter"],
                        "body-reading-translation": ["Inter"],
                        "body-reading-arabic": ["Noto Serif"]
                    },
                    "fontSize": {
                        "label-md": ["14px", {
                            "lineHeight": "1.4",
                            "letterSpacing": "0.02em",
                            "fontWeight": "500"
                        }],
                        "caption": ["12px", {
                            "lineHeight": "1.4",
                            "fontWeight": "400"
                        }],
                        "headline-lg": ["28px", {
                            "lineHeight": "1.3",
                            "fontWeight": "600"
                        }],
                        "headline-xl": ["36px", {
                            "lineHeight": "1.2",
                            "fontWeight": "700"
                        }],
                        "body-reading-translation": ["18px", {
                            "lineHeight": "1.6",
                            "fontWeight": "400"
                        }],
                        "body-reading-arabic": ["32px", {
                            "lineHeight": "2.0",
                            "fontWeight": "400"
                        }]
                    }
                }
            }
        }
    </script>
    <style>
        .pattern-bg {
            background-image: radial-gradient(var(--tw-colors-primary-container) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.03;
        }
    </style>
</head>

<body class="bg-background text-on-background min-h-screen font-body-reading-translation relative">
    <!-- Background Pattern -->
    <div class="fixed inset-0 pattern-bg pointer-events-none z-0"></div>
    
    <!-- TopNavBar -->
    @include('partials.navbar')
    
    <!-- Main Canvas -->
    <main class="relative z-10 max-w-container-max mx-auto px-4 md:px-8 pt-8 pb-24">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-lg border-b border-surface-variant pb-2">
            <h2 class="font-headline-lg text-headline-lg text-primary inline-block">
                Daftar Surah
            </h2>
            <div class="relative max-w-md w-full md:w-80">
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-outline text-sm" data-icon="search">search</span>
                </div>
                <input id="searchSurahInput" 
                       class="w-full pl-9 pr-10 py-2 bg-surface rounded-full border border-outline-variant text-on-surface focus:outline-none focus:ring-1 focus:ring-primary font-label-md text-sm"
                       placeholder="Cari surah..." 
                       type="text" 
                       autocomplete="off" />
                <div id="searchClearBtn" class="absolute inset-y-0 right-3 flex items-center cursor-pointer hidden">
                    <span class="material-symbols-outlined text-outline text-sm hover:text-primary transition-colors">close</span>
                </div>
            </div>
        </div>

        <!-- List View of Surahs -->
        <div id="surahListContainer">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6" id="surahList">
                
                @foreach ($surahs as $surah)
                <a href="{{ route('surah.show', $surah->no_surah) }}" 
                   class="surah-item block bg-surface rounded-2xl border border-outline-variant p-5 hover:border-primary hover:shadow-md hover:bg-surface-container-low hover:-translate-y-1 transition-all duration-300 group"
                   data-surah-name="{{ strtolower($surah->nama_latin) }}"
                   data-surah-arti="{{ strtolower($surah->arti) }}"
                   data-surah-number="{{ $surah->no_surah }}">
                   
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 rounded-full bg-primary-fixed/30 flex items-center justify-center flex-shrink-0 group-hover:bg-primary transition-colors duration-300">
                            <span class="font-label-md text-primary font-bold group-hover:text-on-primary transition-colors duration-300">{{ $surah->no_surah }}</span>
                        </div>
                        
                        <div class="text-right flex-shrink-0">
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
            
            <div id="noResults" class="text-center py-12 hidden col-span-full">
                <span class="material-symbols-outlined text-5xl text-outline mb-3 block">search_off</span>
                <p class="text-on-surface-variant font-medium">Tidak ada surah yang ditemukan</p>
                <p class="text-sm text-outline mt-1">Coba dengan kata kunci lain</p>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    @include('partials.footer')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchSurahInput');
        const searchClearBtn = document.getElementById('searchClearBtn');
        const surahList = document.getElementById('surahList');
        const noResults = document.getElementById('noResults');
        let searchTimeout;
        
        function filterSurahs() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const surahItems = document.querySelectorAll('.surah-item');
            let hasResults = false;
            
            surahItems.forEach(item => {
                const surahName = item.getAttribute('data-surah-name');
                const surahArti = item.getAttribute('data-surah-arti');
                const surahNumber = item.getAttribute('data-surah-number');
                
                if (searchTerm === '' || 
                    surahName.includes(searchTerm) || 
                    surahArti.includes(searchTerm) || 
                    surahNumber === searchTerm) {
                    item.style.display = 'block';
                    hasResults = true;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Tampilkan pesan jika tidak ada hasil
            if (!hasResults && searchTerm !== '') {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }
        
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(filterSurahs, 300);
            
            // Tampilkan/sembunyikan tombol clear
            if (this.value.length > 0) {
                searchClearBtn.classList.remove('hidden');
            } else {
                searchClearBtn.classList.add('hidden');
            }
        });
        
        searchClearBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchClearBtn.classList.add('hidden');
            filterSurahs();
            searchInput.focus();
        });
        
        // Shortcut Ctrl+K / Cmd+K
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
            }
        });
    });
    </script>
</body>

</html>