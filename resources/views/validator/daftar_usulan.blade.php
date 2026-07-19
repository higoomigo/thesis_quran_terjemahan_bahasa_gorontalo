<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;family=Noto+Serif:ital,wght@0,400;0,700;1,400&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <style>
        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24
        }

        body {
            background-color: #f9f9ff
        }

        .islamic-pattern {
            background-image: url(https://lh3.googleusercontent.com/aida-public/AB6AXuDxxQCOnRiwEBQB2rMVqeIgGLPkM3M1ZUOKyp3Rmrw2ZAy-OkPRCNZjF302rwmj4MGFRBftLOrwI2GqhRsR8L5119avaUscx4hWAE_zvy-OmyVxFZzgf4-MEZf4_o1ZxVErS6xY-efnz7yNIxyKOjigfrhr-PfOW0JmwPn8f0JK-_IRtpnAj6NqHZwnNofBj0j7ndMQPfpmOcftZu5rtU9sJHiZk4Jn1Zf7iMWeN0WFCyBnCXzmWH2JkPNgc6Jt-QGbtjYOjLBX6XsX);
            opacity: 0.03
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "outline": "#6f7973",
                        "on-secondary-container": "#682c00",
                        "surface-container-low": "#f0f3ff",
                        "on-error-container": "#93000a",
                        "on-background": "#151c27",
                        "on-tertiary-fixed": "#002115",
                        "on-tertiary-container": "#a8d0bc",
                        "on-primary-fixed-variant": "#00513b",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed-dim": "#a8cfbc",
                        "on-secondary": "#ffffff",
                        "error-container": "#ffdad6",
                        "surface-container-highest": "#dce2f3",
                        "background": "#f9f9ff",
                        "outline-variant": "#bec9c2",
                        "on-primary": "#ffffff",
                        "inverse-on-surface": "#ebf1ff",
                        "tertiary-fixed": "#c3ecd7",
                        "surface-dim": "#d3daea",
                        "on-tertiary-fixed-variant": "#294e3f",
                        "secondary-fixed": "#ffdbca",
                        "on-surface-variant": "#3f4944",
                        "secondary-container": "#fd8a42",
                        "primary": "#004532",
                        "inverse-primary": "#8bd6b6",
                        "on-tertiary": "#ffffff",
                        "surface-variant": "#dce2f3",
                        "on-error": "#ffffff",
                        "on-primary-container": "#8bd6b7",
                        "surface-tint": "#1b6b51",
                        "error": "#ba1a1a",
                        "tertiary": "#1e4334",
                        "primary-fixed-dim": "#8bd6b6",
                        "on-surface": "#151c27",
                        "tertiary-container": "#365a4a",
                        "surface-container": "#e7eefe",
                        "surface-container-high": "#e2e8f8",
                        "secondary-fixed-dim": "#ffb68e",
                        "on-secondary-fixed": "#331200",
                        "secondary": "#9b4500",
                        "inverse-surface": "#2a313d",
                        "on-secondary-fixed-variant": "#763300",
                        "primary-container": "#065f46",
                        "surface-bright": "#f9f9ff",
                        "on-primary-fixed": "#002116",
                        "primary-fixed": "#a6f2d1",
                        "surface": "#f9f9ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "md": "1rem",
                        "unit": "4px",
                        "xl": "2.5rem",
                        "gutter": "1.5rem",
                        "xs": "0.25rem",
                        "sm": "0.5rem",
                        "lg": "1.5rem",
                        "container-max": "1200px"
                    },
                    "fontFamily": {
                        "body-reading-arabic": ["Noto Serif"],
                        "caption": ["Inter"],
                        "headline-lg": ["Inter"],
                        "label-md": ["Inter"],
                        "body-reading-translation": ["Inter"],
                        "headline-xl": ["Inter"]
                    },
                    "fontSize": {
                        "body-reading-arabic": ["32px", {
                            "lineHeight": "2.0",
                            "fontWeight": "400"
                        }],
                        "caption": ["12px", {
                            "lineHeight": "1.4",
                            "fontWeight": "400"
                        }],
                        "headline-lg": ["28px", {
                            "lineHeight": "1.3",
                            "fontWeight": "600"
                        }],
                        "label-md": ["14px", {
                            "lineHeight": "1.4",
                            "letterSpacing": "0.02em",
                            "fontWeight": "500"
                        }],
                        "body-reading-translation": ["18px", {
                            "lineHeight": "1.6",
                            "fontWeight": "400"
                        }],
                        "headline-xl": ["36px", {
                            "lineHeight": "1.2",
                            "fontWeight": "700"
                        }]
                    }
                },
            },
        }
    </script>
</head>

<body class="font-body-reading-translation text-on-background">
    <!-- Sidebar Layout Container -->
    <div class="flex min-h-screen">
        <!-- SideNavBar -->
        @include('partials.sidebar')
        <!-- Main Content Canvas -->
        <main class="flex-1 ml-64 p-8 relative overflow-hidden">
            <div class="absolute inset-0 islamic-pattern pointer-events-none"></div>
            <div class="max-w-6xl mx-auto relative z-10">
                <!-- Breadcrumbs -->
                <nav aria-label="Breadcrumb" class="flex mb-6 text-sm font-medium">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a class="text-slate-500 hover:text-emerald-700 transition-colors"
                                href="#">Dashboard</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <span class="material-symbols-outlined text-slate-400 text-lg mr-2"
                                    data-icon="chevron_right">chevron_right</span>
                                <span class="text-emerald-800 font-bold">Antrean Otorisasi</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div>
                        <h2 class="font-headline-xl text-headline-xl text-primary tracking-tight">Daftar Usulan Publik</h2>
                        <p class="text-on-surface-variant font-label-md">Review usulan terjemahan .</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2">
                            <img alt="Admin Avatar" class="w-10 h-10 rounded-full border-2 border-white"
                                data-alt="Close-up portrait of a scholarly man with glasses, representing a theological validator, in a professional and bright office setting with neutral colors."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuD9JwRtHflHlgpOSMftwmvnLSkH4YcaCfL60-mFcSvByhlg7QMRRnpbodK1YnVZK8KbOq138mLQvJxjM-tqybjki2EX6WCaYOcuKt9GLzqxq_BkVbkfojWm1TKzmoACzaKsrDT2u0KKyoH0gJ2_jFgITrxl7rK_MA71Y94GUMiJR55_YgwLK77NcjI9bWZeBNDkDFJuEdIAz0CeaWHzBrTmWLsZjBs_r4qu9Lm8Wjr5u5yv9tEtrJRyj7CPIWcfwY6XSSjWf80otBvV" />
                            <div
                                class="w-10 h-10 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center text-emerald-800 font-bold text-xs">
                                +3</div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-on-surface">Ustadz Ahmad</p>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest font-black">Senior Validator
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Filters & Search -->
                <div
                    class="bg-white/80 backdrop-blur-md rounded-xl p-4 mb-6 shadow-sm border border-slate-100 flex flex-wrap items-center gap-4">
                    <div class="relative flex-1 min-w-[240px]">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
                            data-icon="search">search</span>
                        <input
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-sm transition-all"
                            placeholder="Cari Surah atau Kata Kunci..." type="text" />
                    </div>
                    <div class="flex items-center gap-2">
                        <button
                            class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                            <span class="material-symbols-outlined text-lg" data-icon="filter_list">filter_list</span>
                            Filter Juz
                        </button>
                        <button
                            class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                            <span class="material-symbols-outlined text-lg" data-icon="sort">sort</span>
                            Terlama
                        </button>
                    </div>
                    <div class="h-8 w-px bg-slate-200 hidden md:block"></div>
                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-slate-500">Tampilan:</span>
                        <div class="flex bg-slate-100 p-1 rounded-lg">
                            <button class="p-1.5 bg-white rounded shadow-sm text-emerald-700">
                                <span class="material-symbols-outlined text-lg block"
                                    data-icon="table_rows">table_rows</span>
                            </button>
                            <button class="p-1.5 text-slate-400 hover:text-slate-600 transition-colors">
                                <span class="material-symbols-outlined text-lg block"
                                    data-icon="grid_view">grid_view</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Data Table -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="px-6 py-4 font-bold text-emerald-900 text-sm">Surah/Ayat</th>
                                <th class="px-6 py-4 font-bold text-emerald-900 text-sm">Usulan Diksi Baru</th>
                                <th class="px-6 py-4 font-bold text-emerald-900 text-sm">Catatan Linguistik</th>
                                <th class="px-6 py-4 font-bold text-emerald-900 text-sm">Tanggal Masuk</th>
                                <th class="px-6 py-4 font-bold text-emerald-900 text-sm text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <!-- Row 1 -->
                            <tr class="hover:bg-emerald-50/30 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-on-surface">Al-Fatihah: 2</span>
                                        <span class="text-xs text-slate-500">Juz 1</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="max-w-md">
                                        <p
                                            class="text-body-reading-translation leading-relaxed text-emerald-900 italic">
                                            "Ngo'idi hilawo u muliya to Allahu Ta'ala..."</p>
                                        <div class="mt-2 flex">
                                            <span
                                                class="bg-surface-container-low text-secondary font-bold text-[10px] px-2 py-0.5 rounded-full uppercase tracking-tight">Linguistik
                                                OK</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm text-slate-600 italic border-l-2 border-emerald-200 pl-3">
                                        "Penyesuaian dialek Gorontalo pesisir agar lebih inklusif."</p>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-sm text-slate-500">12 Okt 2023</span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <button
                                        class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-surface-tint active:scale-95 transition-all flex items-center justify-center gap-2 mx-auto">
                                        <span class="material-symbols-outlined text-sm"
                                            data-icon="auto_awesome">auto_awesome</span>
                                        Proses Final
                                    </button>
                                </td>
                            </tr>
                            <!-- Row 2 -->
                            <tr class="hover:bg-emerald-50/30 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-on-surface">Al-Baqarah: 183</span>
                                        <span class="text-xs text-slate-500">Juz 2</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="max-w-md">
                                        <p
                                            class="text-body-reading-translation leading-relaxed text-emerald-900 italic">
                                            "O mongoli u botiye pilomarenta lo Allahu..."</p>
                                        <div class="mt-2 flex">
                                            <span
                                                class="bg-surface-container-low text-secondary font-bold text-[10px] px-2 py-0.5 rounded-full uppercase tracking-tight">Linguistik
                                                OK</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm text-slate-600 italic border-l-2 border-emerald-200 pl-3">
                                        "Penggunaan kata serapan Arab yang sudah baku di masyarakat."</p>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-sm text-slate-500">14 Okt 2023</span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <button
                                        class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-surface-tint active:scale-95 transition-all flex items-center justify-center gap-2 mx-auto">
                                        <span class="material-symbols-outlined text-sm"
                                            data-icon="auto_awesome">auto_awesome</span>
                                        Proses Final
                                    </button>
                                </td>
                            </tr>
                            <!-- Row 3 -->
                            <tr class="hover:bg-emerald-50/30 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-on-surface">Yasin: 12</span>
                                        <span class="text-xs text-slate-500">Juz 22</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="max-w-md">
                                        <p
                                            class="text-body-reading-translation leading-relaxed text-emerald-900 italic">
                                            "Tantu Amiyalo u mopohulayi lo ta mate..."</p>
                                        <div class="mt-2 flex">
                                            <span
                                                class="bg-surface-container-low text-secondary font-bold text-[10px] px-2 py-0.5 rounded-full uppercase tracking-tight">Linguistik
                                                OK</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm text-slate-600 italic border-l-2 border-emerald-200 pl-3">
                                        "Koreksi pada imbuhan verba agar sesuai dengan tata bahasa."</p>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-sm text-slate-500">15 Okt 2023</span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <button
                                        class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-surface-tint active:scale-95 transition-all flex items-center justify-center gap-2 mx-auto">
                                        <span class="material-symbols-outlined text-sm"
                                            data-icon="auto_awesome">auto_awesome</span>
                                        Proses Final
                                    </button>
                                </td>
                            </tr>
                            <!-- Row 4 -->
                            <tr class="hover:bg-emerald-50/30 transition-colors group border-b-0">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-on-surface">An-Naba: 1-5</span>
                                        <span class="text-xs text-slate-500">Juz 30</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="max-w-md">
                                        <p
                                            class="text-body-reading-translation leading-relaxed text-emerald-900 italic">
                                            "Wolo u hihula-hulaliyo lo timongoliyo?"</p>
                                        <div class="mt-2 flex">
                                            <span
                                                class="bg-surface-container-low text-secondary font-bold text-[10px] px-2 py-0.5 rounded-full uppercase tracking-tight">Linguistik
                                                OK</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm text-slate-600 italic border-l-2 border-emerald-200 pl-3">"Gaya
                                        bahasa retoris disesuaikan dengan nada sastra lokal."</p>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-sm text-slate-500">16 Okt 2023</span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <button
                                        class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-surface-tint active:scale-95 transition-all flex items-center justify-center gap-2 mx-auto">
                                        <span class="material-symbols-outlined text-sm"
                                            data-icon="auto_awesome">auto_awesome</span>
                                        Proses Final
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-slate-50/50 flex items-center justify-between border-t border-slate-100">
                        <p class="text-xs text-slate-500 font-medium">Menampilkan 4 dari 124 usulan</p>
                        <div class="flex items-center gap-1">
                            <button
                                class="p-2 text-slate-400 hover:text-emerald-700 transition-colors disabled:opacity-30"
                                disabled="">
                                <span class="material-symbols-outlined text-lg block"
                                    data-icon="chevron_left">chevron_left</span>
                            </button>
                            <button class="w-8 h-8 rounded bg-primary text-on-primary text-xs font-bold">1</button>
                            <button
                                class="w-8 h-8 rounded hover:bg-emerald-100 text-slate-600 text-xs font-bold transition-colors">2</button>
                            <button
                                class="w-8 h-8 rounded hover:bg-emerald-100 text-slate-600 text-xs font-bold transition-colors">3</button>
                            <span class="px-1 text-slate-400">...</span>
                            <button
                                class="w-8 h-8 rounded hover:bg-emerald-100 text-slate-600 text-xs font-bold transition-colors">31</button>
                            <button class="p-2 text-slate-400 hover:text-emerald-700 transition-colors">
                                <span class="material-symbols-outlined text-lg block"
                                    data-icon="chevron_right">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Summary Cards (Asymmetric Layout Hint) -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-24 h-24 -mr-8 -mt-8 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform">
                        </div>
                        <div class="relative z-10">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Antrean
                            </p>
                            <h3 class="text-3xl font-black text-emerald-900">124</h3>
                            <p class="text-xs text-emerald-600 font-semibold mt-2 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs"
                                    data-icon="trending_up">trending_up</span>
                                +12 hari ini
                            </p>
                        </div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-24 h-24 -mr-8 -mt-8 bg-on-tertiary-container/10 rounded-full group-hover:scale-110 transition-transform">
                        </div>
                        <div class="relative z-10">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Priority
                                (Urgent)</p>
                            <h3 class="text-3xl font-black text-secondary">18</h3>
                            <p class="text-xs text-secondary font-semibold mt-2">Segera validasi Juz 30</p>
                        </div>
                    </div>
                    <div
                        class="md:col-span-1 bg-emerald-900 text-on-primary p-6 rounded-xl shadow-lg relative overflow-hidden">
                        <div class="absolute inset-0 islamic-pattern opacity-10"></div>
                        <div class="relative z-10 flex flex-col h-full justify-between">
                            <div>
                                <h4 class="font-bold text-lg mb-1">Target Penyelesaian</h4>
                                <p class="text-xs text-emerald-300">Ramadhan Edition 1445H</p>
                            </div>
                            <div class="mt-4">
                                <div class="w-full bg-emerald-800 rounded-full h-1.5 mb-2">
                                    <div class="bg-emerald-400 h-1.5 rounded-full" style="width: 72%"></div>
                                </div>
                                <p class="text-right text-[10px] font-bold text-emerald-400">72% Progres Kolektif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
