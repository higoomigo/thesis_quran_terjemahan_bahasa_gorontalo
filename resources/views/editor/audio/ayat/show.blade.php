{{-- resources/views/editor/audio/ayat/show.blade.php --}}
@extends('layouts.app_editor')

@section('title', 'Detail Audio Surah ' . $surah->nama_latin)

@section('content')
<main class="flex-1 ml-64 px-6 bg-gray-50/50 min-h-screen pb-12">
    <!-- Header & Breadcrumbs -->
    <header class="max-w-6xl mx-auto mb-6 pt-6">
        <nav class="flex items-center gap-2 text-gray-500 mb-4">
            <a href="{{ route('editor.dashboard') }}" class="text-xs hover:text-emerald-600 transition-colors">Beranda</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-xs">Manajemen Audio</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <a href="{{ route('editor.audio.ayat.index') }}" class="text-xs hover:text-emerald-600 transition-colors">Audio Per Ayat</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-xs text-emerald-700 font-medium">{{ $surah->nama_latin }}</span>
        </nav>
        
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('editor.audio.ayat.index') }}" class="w-10 h-10 bg-white border border-gray-200 text-gray-500 rounded-xl flex items-center justify-center hover:bg-gray-50 hover:text-emerald-600 transition-all shadow-sm">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">
                        Surah {{ $surah->nama_latin }} 
                        <span class="text-xl font-normal text-gray-500 ml-2">({{ $surah->arabic_name ?? 'Arabic' }})</span>
                    </h2>
                    <p class="text-gray-600 mt-1">{{ $surah->arti }} • {{ $surah->jumlah_ayat }} Ayat</p>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Alert Notifikasi -->
        @if(session('success'))
            <div class="p-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-100 shadow-sm flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 text-sm text-red-800 rounded-xl bg-red-50 border border-red-100 shadow-sm flex items-center gap-3">
                <span class="material-symbols-outlined">error</span>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="p-4 text-sm text-red-800 rounded-xl bg-red-50 border border-red-100 shadow-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- CARD: UPLOAD ZIP (MASSAL) -->
        <!-- CARD: UPLOAD ZIP (MASSAL) -->
        <!-- CARD: UPLOAD ZIP (MASSAL) -->
       <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden" 
            x-data="{ 
                jenisZip: '', 
                selectedLanggam: '',
                langgamsData: {{ Js::from($langgams) }},
                get qarisTersedia() {
                    if (!this.selectedLanggam) return [];
                    const langgam = this.langgamsData.find(l => l.id == this.selectedLanggam);
                    return langgam && langgam.pelantuns ? langgam.pelantuns : [];
                }
            }">
            <div class="bg-emerald-50/50 px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <span class="material-symbols-outlined text-emerald-600">folder_zip</span>
                <h3 class="text-lg font-bold text-gray-800">Upload ZIP (Massal) untuk {{ $surah->nama_latin }}</h3>
            </div>
            
            <form action="{{ route('editor.audio.ayat.storeZip', $surah->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="space-y-4 md:col-span-3">
                        
                        <!-- Pilihan Jenis Audio -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pilih Jenis Audio yang ingin diupload</label>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="jenis_zip" value="arab" x-model="jenisZip" class="peer hidden" required>
                                    <div class="rounded-xl border-2 border-gray-200 bg-gray-50 py-3 px-4 text-center text-sm font-bold text-gray-500 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition-all">
                                        Arab (Qari)
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="jenis_zip" value="gorontalo" x-model="jenisZip" class="peer hidden" required>
                                    <div class="rounded-xl border-2 border-gray-200 bg-gray-50 py-3 px-4 text-center text-sm font-bold text-gray-500 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition-all">
                                        Gorontalo
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Muncul HANYA jika milih ARAB -->
                        <!-- Muncul HANYA jika milih ARAB -->
                        <div x-show="jenisZip === 'arab'" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-600 mb-1.5">Pilih Langgam</label>
                                <select name="langgam_id" 
                                        x-model="selectedLanggam" 
                                        x-bind:required="jenisZip === 'arab'" 
                                        class="w-full rounded-lg border-gray-300 bg-white py-2 px-3 text-sm focus:border-emerald-500 outline-none">
                                    <option value="">-- Pilih Langgam --</option>
                                    @foreach($langgams as $langgam)
                                        <option value="{{ $langgam->id }}">{{ $langgam->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-600 mb-1.5">Qari (Arab)</label>
                                <select name="pelantun_id" 
                                        x-bind:required="jenisZip === 'arab'" 
                                        class="w-full rounded-lg border-gray-300 bg-white py-2 px-3 text-sm focus:border-emerald-500 outline-none">
                                    <option value="">-- Pilih Qari --</option>
                                    <template x-for="qari in qarisTersedia" :key="qari.id">
                                        <option :value="qari.id" x-text="qari.nama"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <!-- Muncul HANYA jika milih GORONTALO -->
                        <div x-show="jenisZip === 'gorontalo'" x-transition class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <label class="block text-[11px] font-semibold text-gray-600 mb-1.5">Pembaca Terjemahan Gorontalo</label>
                            <select name="pembaca_gorontalo_id" x-bind:required="jenisZip === 'gorontalo'" class="w-full rounded-lg border-gray-300 bg-white py-2 px-3 text-sm focus:border-emerald-500 outline-none">
                                <option value="">-- Pilih Pembaca --</option>
                                @foreach($pembacas as $p) <option value="{{ $p->id }}">{{ $p->nama }}</option> @endforeach
                            </select>
                        </div>
                        
                        <!-- Input File (biarkan seperti sebelumnya) -->
                        <div class="text-xs text-gray-500 bg-emerald-50 p-3 rounded-lg border border-emerald-100 flex gap-2">
                            <span class="material-symbols-outlined text-emerald-500 text-base">info</span>
                            <p>Pastikan nama file di dalam ZIP menggunakan format angka urut (contoh: <strong>1.mp3, 2.mp3</strong>).</p>
                        </div>
                    </div>
                    <div class="flex flex-col justify-end gap-2">
                        <input type="file" name="file_zip" accept=".zip" required class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-gray-200 rounded-lg bg-gray-50">
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl transition duration-200 shadow-sm active:scale-95 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">unarchive</span> Ekstrak ZIP
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- AREA AJAX: KONTENER UNTUK TABEL DAN MODAL -->
        <div id="ajax-container">
            
            <!-- LIST AYAT & UPLOAD ECERAN -->
            <!-- LIST AYAT & UPLOAD ECERAN -->
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm transition-opacity duration-300" id="ayat-list-card">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Daftar Audio Per Ayat</h3>
                            <p class="text-xs text-gray-500">Filter berdasarkan Langgam, Qari, atau Pembaca Gorontalo.</p>
                        </div>
                    </div>

                    <!-- FILTER FORM -->
                    <form id="filterLanggamForm" action="{{ route('editor.audio.ayat.show', $surah->id) }}" method="GET" 
                        class="grid grid-cols-1 md:grid-cols-4 gap-3"
                        x-data="{
                            selectedLanggam: '{{ $langgamId ?? '' }}',
                            selectedQari: '{{ $qariId ?? '' }}',
                            langgamsData: {{ Js::from($langgams) }},
                            get qarisTersedia() {
                                if (!this.selectedLanggam) return [];
                                const langgam = this.langgamsData.find(l => l.id == this.selectedLanggam);
                                return langgam && langgam.pelantuns ? langgam.pelantuns : [];
                            },
                            init() {
                                // Set selected Qari setelah Alpine siap
                                this.$nextTick(() => {
                                    if (this.$refs.qariSelect && this.selectedQari) {
                                        this.$refs.qariSelect.value = this.selectedQari;
                                    }
                                });
                            }
                        }">
                        
                        <!-- Langgam -->
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 mb-1">Langgam (Arab)</label>
                            <select name="langgam_id" x-model="selectedLanggam" class="w-full rounded-xl border-gray-300 bg-white py-2 px-3 text-sm focus:border-emerald-500 outline-none">
                                <option value="">-- Semua Langgam --</option>
                                @foreach($langgams as $langgam)
                                    <option value="{{ $langgam->id }}" {{ $langgamId == $langgam->id ? 'selected' : '' }}>
                                        {{ $langgam->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Qari (dependent) -->
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 mb-1">Qari (Arab)</label>
                            <select name="qari_id" 
                                    class="w-full rounded-xl border-gray-300 bg-white py-2 px-3 text-sm focus:border-emerald-500 outline-none"
                                    x-ref="qariSelect">
                                <option value="">-- Semua Qari --</option>
                                <template x-for="qari in qarisTersedia" :key="qari.id">
                                    <option :value="qari.id" x-text="qari.nama"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Pembaca Gorontalo -->
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 mb-1">Pembaca Gorontalo</label>
                            <select name="pembaca_gorontalo_id" class="w-full rounded-xl border-gray-300 bg-white py-2 px-3 text-sm focus:border-emerald-500 outline-none">
                                <option value="">-- Semua Pembaca --</option>
                                @foreach($pembacas as $p)
                                    <option value="{{ $p->id }}" {{ $pembacaGorontaloId == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-xl transition shadow-sm active:scale-95 flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-sm">search</span> Filter
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white text-gray-500 border-b border-gray-200">
                                <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider w-16 text-center">Ayat</th>
                                <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">Teks Ayat</th>
                                <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">Status & Putar Audio</th>
                                <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($surah->ayats as $ayat)
                                @php
                                    // ===== AUDIO ARAB =====
                                    $audioArab = null;
                                    if ($langgamId || $qariId) {
                                        $queryArab = \App\Models\AudioArab::where('ayat_id', $ayat->id);
                                        if ($langgamId) $queryArab->where('langgam_id', $langgamId);
                                        if ($qariId) $queryArab->where('qari_id', $qariId);
                                        $audioArab = $queryArab->first();
                                    }

                                    // ===== AUDIO GORONTALO =====
                                    $audioGto = null;
                                    if ($pembacaGorontaloId) {
                                        $audioGto = \App\Models\AudioGorontalo::where('ayat_id', $ayat->id)
                                            ->where('pembaca_gorontalo_id', $pembacaGorontaloId)
                                            ->first();
                                    } elseif (!$langgamId && !$qariId) {
                                        // Kalau tidak ada filter sama sekali, tampilkan salah satu saja (opsional)
                                        $audioGto = \App\Models\AudioGorontalo::where('ayat_id', $ayat->id)->first();
                                    }

                                    $fileArab = $audioArab?->file_path;
                                    $fileGto  = $audioGto?->file_path;
                                @endphp

                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-6 py-4 text-center align-top">
                                        <span class="inline-flex w-8 h-8 items-center justify-center rounded-full bg-gray-100 text-gray-700 font-bold text-sm">
                                            {{ $ayat->nomorAyat }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <p class="text-3xl arabic-text text-right mb-3 text-gray-800 leading-loose" dir="rtl">{{ $ayat->Arab ?? 'Teks Arab Kosong' }}</p>
                                        <p class="text-sm text-gray-600 italic">"{{ $ayat->teks_gorontalo ?? 'Teks Gorontalo belum diinput.' }}"</p>
                                    </td>
                                    
                                    <td class="px-6 py-4 align-top">
                                        <div class="flex flex-col gap-3 w-full">
                                            <!-- Player Arab -->
                                            @if($fileArab)
                                                <div class="custom-audio-player flex items-center gap-3 bg-gray-50 border border-gray-200 p-2.5 rounded-xl w-64 shadow-sm hover:border-emerald-300 transition-colors">
                                                    <audio src="{{ asset('storage/' . $fileArab) }}" preload="metadata" class="hidden-audio"></audio>
                                                    <button type="button" class="play-btn w-9 h-9 flex-shrink-0 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center hover:bg-emerald-200 transition-all active:scale-95">
                                                        <span class="material-symbols-outlined text-[20px] play-icon" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
                                                    </button>
                                                    <div class="flex-1">
                                                        <div class="flex justify-between items-center mb-1.5">
                                                            <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Arab</span>
                                                            <span class="text-[10px] text-gray-500 font-mono time-display">0:00 / 0:00</span>
                                                        </div>
                                                        <div class="bg-gray-200 h-1.5 rounded-full overflow-hidden cursor-pointer progress-container">
                                                            <div class="bg-emerald-500 h-full w-0 progress-bar pointer-events-none transition-all duration-75"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex items-center gap-3 bg-red-50/50 border border-red-100 p-2.5 rounded-xl w-64 shadow-sm opacity-80">
                                                    <div class="w-9 h-9 flex-shrink-0 bg-red-100 text-red-500 rounded-full flex items-center justify-center">
                                                        <span class="material-symbols-outlined text-[18px]">music_off</span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <span class="text-[10px] font-bold text-red-600 uppercase tracking-wider">Arab</span>
                                                        <span class="text-[10px] text-red-400 italic block">
                                                            {{ ($langgamId || $qariId) ? 'Belum tersedia' : 'Filter Langgam/Qari dulu' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Player Gorontalo -->
                                            @if($fileGto)
                                                <div class="custom-audio-player flex items-center gap-3 bg-gray-50 border border-gray-200 p-2.5 rounded-xl w-64 shadow-sm hover:border-emerald-300 transition-colors">
                                                    <audio src="{{ asset('storage/' . $fileGto) }}" preload="metadata" class="hidden-audio"></audio>
                                                    <button type="button" class="play-btn w-9 h-9 flex-shrink-0 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center hover:bg-emerald-200 transition-all active:scale-95">
                                                        <span class="material-symbols-outlined text-[20px] play-icon" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
                                                    </button>
                                                    <div class="flex-1">
                                                        <div class="flex justify-between items-center mb-1.5">
                                                            <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Gorontalo</span>
                                                            <span class="text-[10px] text-gray-500 font-mono time-display">0:00 / 0:00</span>
                                                        </div>
                                                        <div class="bg-gray-200 h-1.5 rounded-full overflow-hidden cursor-pointer progress-container">
                                                            <div class="bg-emerald-500 h-full w-0 progress-bar pointer-events-none transition-all duration-75"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex items-center gap-3 bg-red-50/50 border border-red-100 p-2.5 rounded-xl w-64 shadow-sm opacity-80">
                                                    <div class="w-9 h-9 flex-shrink-0 bg-red-100 text-red-500 rounded-full flex items-center justify-center">
                                                        <span class="material-symbols-outlined text-[18px]">music_off</span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <span class="text-[10px] font-bold text-red-600 uppercase tracking-wider">Gorontalo</span>
                                                        <span class="text-[10px] text-red-400 italic block">
                                                            {{ $pembacaGorontaloId ? 'Belum tersedia' : 'Filter Pembaca dulu' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center align-top">
                                        <button type="button" 
                                            onclick="openSingleModal({{ $ayat->id }}, {{ $ayat->nomorAyat }})"
                                            class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-white text-gray-700 border border-gray-200 rounded-lg text-xs font-bold hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 transition-all shadow-sm active:scale-95">
                                            <span class="material-symbols-outlined text-[16px]">audio_file</span>
                                            {{ ($fileArab || $fileGto) ? 'Ubah Audio' : 'Upload Audio' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @php
                $selectedLanggam = collect($langgams)->firstWhere('id', request('langgam_id'));
                $langgamName = $selectedLanggam ? $selectedLanggam->nama : 'Silakan filter langgam dahulu';
                $qarisModal = $selectedLanggam ? $selectedLanggam->pelantuns : [];
            @endphp

            <!-- MODAL UPLOAD SINGLE (ECERAN) -->
            <!-- MODAL UPLOAD SINGLE (ECERAN) -->
            <div id="singleUploadModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
                
                <!-- Tambahkan x-data=" { jenisAudio: '' } " di sini -->
                <div class="modal-content-wrapper bg-white rounded-2xl shadow-xl w-full max-w-md transform scale-95 transition-transform duration-300 p-6 relative" x-data="{ jenisAudio: '' }">
                    <button type="button" onclick="closeSingleModal()" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                    
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined">audio_file</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Upload Audio Eceran</h3>
                            <p class="text-xs text-gray-500">Surah {{ $surah->nama_latin }} Ayat ke-<span id="modalNoAyat" class="font-bold text-emerald-600"></span></p>
                        </div>
                    </div>

                    <form action="{{ route('editor.audio.ayat.storeSingle', 0) }}" method="POST" enctype="multipart/form-data" class="space-y-4" id="singleUploadForm">
                        @csrf
                        <input type="hidden" name="audio_id" id="modalAyatAudioId" value="">
                        <input type="hidden" name="ayat_id" id="modalAyatId" value="">

                        <!-- Pilihan Jenis Audio (Radio Box by Alpine) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Audio</label>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="jenis_audio" value="arab" x-model="jenisAudio" class="peer hidden" required>
                                    <div class="rounded-xl border-2 border-gray-200 bg-gray-50 py-2.5 px-3 text-center text-sm font-bold text-gray-500 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition-all">
                                        Arab (Qari)
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="jenis_audio" value="gorontalo" x-model="jenisAudio" class="peer hidden" required>
                                    <div class="rounded-xl border-2 border-gray-200 bg-gray-50 py-2.5 px-3 text-center text-sm font-bold text-gray-500 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition-all">
                                        Gorontalo
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Muncul HANYA jika milih ARAB -->
                        <div x-show="jenisAudio === 'arab'" x-transition class="space-y-4 bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Langgam</label>
                                <!-- Kita disable input langgam_id kalau yang dipilih bukan arab, biar controller ga ngebaca ini pas upload gorontalo -->
                                <input type="hidden" name="langgam_id" id="modalHiddenLanggamId" value="{{ request('langgam_id') }}" x-bind:disabled="jenisAudio !== 'arab'">
                                <input type="text" value="{{ $langgamName }}" readonly class="w-full rounded-lg border border-gray-200 bg-gray-100 py-2 px-3 text-sm outline-none cursor-not-allowed text-gray-500 font-bold">
                                <p class="text-[10px] text-gray-400 mt-1">*Langgam menyesuaikan filter tabel aktif.</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Qari (Arab)</label>
                                <select name="qari_id" x-bind:required="jenisAudio === 'arab'" class="w-full rounded-lg border-gray-300 bg-white py-2 px-3 text-xs focus:border-emerald-500 outline-none">
                                    <option value="">-- Pilih Qari --</option>
                                    @foreach($qarisModal as $q) 
                                        <option value="{{ $q->id }}">{{ $q->nama }}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Muncul HANYA jika milih GORONTALO -->
                        <div x-show="jenisAudio === 'gorontalo'" x-transition class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Pembaca Terjemahan (GTO)</label>
                            <select name="pembaca_gorontalo_id" x-bind:required="jenisAudio === 'gorontalo'" class="w-full rounded-lg border-gray-300 bg-white py-2 px-3 text-xs focus:border-emerald-500 outline-none">
                                <option value="">-- Pilih Pembaca --</option>
                                @foreach($pembacas as $p) 
                                    <option value="{{ $p->id }}">{{ $p->nama }}</option> 
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">File Audio MP3</label>
                            <input type="file" name="file_audio" accept=".mp3" required class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-gray-200 rounded-lg bg-gray-50">
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl transition duration-200 active:scale-95">
                                Upload & Simpan Audio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- AKHIR AREA AJAX -->

    </div>
</main>

<script>
    // FUNGSI INISIALISASI AUDIO PLAYER
    function initAudioPlayers() {
        const players = document.querySelectorAll('.custom-audio-player');
        let currentlyPlaying = null;
        let currentlyPlayingIcon = null;

        players.forEach(player => {
            const audio = player.querySelector('.hidden-audio');
            const playBtn = player.querySelector('.play-btn');
            const playIcon = player.querySelector('.play-icon');
            const progressBar = player.querySelector('.progress-bar');
            const progressContainer = player.querySelector('.progress-container');
            const timeDisplay = player.querySelector('.time-display');

            const formatTime = (time) => {
                if (isNaN(time)) return '0:00';
                const m = Math.floor(time / 60);
                const s = Math.floor(time % 60);
                return `${m}:${s.toString().padStart(2, '0')}`;
            };

            const setDuration = () => { timeDisplay.textContent = `0:00 / ${formatTime(audio.duration)}`; };
            if (audio.readyState > 0) setDuration();
            else audio.addEventListener('loadedmetadata', setDuration);

            playBtn.addEventListener('click', () => {
                if (audio.paused) {
                    if (currentlyPlaying && currentlyPlaying !== audio) {
                        currentlyPlaying.pause();
                        if (currentlyPlayingIcon) currentlyPlayingIcon.textContent = 'play_arrow';
                    }
                    audio.play();
                    playIcon.textContent = 'pause';
                    currentlyPlaying = audio;
                    currentlyPlayingIcon = playIcon;
                } else {
                    audio.pause();
                    playIcon.textContent = 'play_arrow';
                    currentlyPlaying = null;
                }
            });

            audio.addEventListener('timeupdate', () => {
                const percent = (audio.currentTime / audio.duration) * 100;
                progressBar.style.width = `${percent}%`;
                timeDisplay.textContent = `${formatTime(audio.currentTime)} / ${formatTime(audio.duration)}`;
            });

            audio.addEventListener('ended', () => {
                playIcon.textContent = 'play_arrow';
                progressBar.style.width = '0%';
                timeDisplay.textContent = `0:00 / ${formatTime(audio.duration)}`;
                currentlyPlaying = null;
            });

            progressContainer.addEventListener('click', (e) => {
                const rect = progressContainer.getBoundingClientRect();
                const pos = (e.clientX - rect.left) / rect.width;
                audio.currentTime = pos * audio.duration;
            });
        });
    }

    // FUNGSI BIND FORM AJAX
    function bindFilterForm() {
    const filterForm = document.getElementById('filterLanggamForm');
    if (!filterForm) return;

    // Hindari event listener dobel
    const newForm = filterForm.cloneNode(true);
    filterForm.parentNode.replaceChild(newForm, filterForm);

    newForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const url = new URL(this.action);
        url.search = new URLSearchParams(new FormData(this)).toString();

        const cardContainer = document.getElementById('ayat-list-card');
        if (cardContainer) {
            cardContainer.style.opacity = '0.4';
            cardContainer.style.pointerEvents = 'none';
        }

        fetch(url.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContent = doc.getElementById('ajax-container');

            if (newContent) {
                const container = document.getElementById('ajax-container');
                container.innerHTML = newContent.innerHTML;

                // ===== FIX UTAMA: Init ulang Alpine =====
                if (window.Alpine) {
                    Alpine.initTree(container);
                }

                window.history.pushState({}, '', url);

                // Re-init
                initAudioPlayers();
                bindFilterForm();
            } else {
                window.location.href = url.toString();
            }
        })
        .catch(error => {
            console.error('Filter error:', error);
            if (cardContainer) {
                cardContainer.style.opacity = '1';
                cardContainer.style.pointerEvents = 'auto';
            }
            alert('Gagal memfilter. Silakan refresh halaman.');
        });
    });
}

    // Eksekusi saat halaman pertama load
    document.addEventListener('DOMContentLoaded', function() {
        initAudioPlayers();
        bindFilterForm();
    });

    // Handle back button browser biar nggak error
    window.addEventListener('popstate', function () {
        window.location.reload();
    });

    // FUNGSI MODAL DINAMIS
    function openSingleModal(ayatId, noAyat) {
    const modal = document.getElementById('singleUploadModal');
    const modalContent = modal.querySelector('.modal-content-wrapper');
    const form = document.getElementById('singleUploadForm');

    // Set action form ke ayat_id yang benar
    form.action = `{{ url('editor/audio/ayat') }}/${ayatId}/upload-single`;

    document.getElementById('modalAyatId').value = ayatId;
    document.getElementById('modalNoAyat').textContent = noAyat;
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
    }, 10);
}

    function closeSingleModal() {
        const modal = document.getElementById('singleUploadModal');
        const modalContent = modal.querySelector('.modal-content-wrapper');
        
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection