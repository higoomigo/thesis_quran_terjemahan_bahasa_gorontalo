@extends('layouts.app_editor')

@section('title', 'Master Langgam')

@section('content')
<main class="flex-1 ml-64 px-6 py-8 bg-slate-50 min-h-screen" x-data="langgamManager()">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4 mb-8 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Master Langgam</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola direktori irama murottal dan relasinya dengan Qari.</p>
            </div>
            <button @click="openCreate()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all shadow-sm hover:shadow active:scale-95 flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">add_circle</span> Tambah Langgam
            </button>
        </div>

        <!-- Alert Notifikasi -->
        @if(session('success'))
            <div class="p-4 mb-6 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 shadow-sm flex items-center gap-3 animate-fade-in-down">
                <span class="material-symbols-outlined text-[20px]">check_circle</span> 
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Table Section -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500">
                            <th class="px-6 py-4 font-bold w-12 text-center">No</th>
                            <th class="px-6 py-4 font-bold">Informasi Langgam</th>
                            <th class="px-6 py-4 font-bold">Qari Terkait</th>
                            <th class="px-6 py-4 font-bold text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($langgams as $langgam)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-5 text-center text-sm font-bold text-slate-400 align-top">{{ $loop->iteration }}</td>
                                <td class="px-6 py-5 align-top">
                                    <h4 class="font-bold text-slate-800 text-base mb-1">{{ $langgam->nama }}</h4>
                                    <p class="text-sm text-slate-500 line-clamp-2">{{ $langgam->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                                </td>
                                <td class="px-6 py-5 align-top">
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse($langgam->pelantuns as $pelantun)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <span class="material-symbols-outlined text-[14px]">mic</span>
                                                {{ $pelantun->nama }}
                                            </span>
                                        @empty
                                            <span class="text-xs italic text-slate-400">Belum ada Qari</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center align-top">
                                    <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <!-- Tombol Edit Modal -->
                                        <button @click="openEdit({{ $langgam->id }}, '{{ addslashes($langgam->nama) }}', '{{ addslashes($langgam->deskripsi) }}', {{ $langgam->pelantuns->pluck('id')->toJson() }})" 
                                                class="text-amber-600 hover:text-amber-700 hover:bg-amber-50 p-2 rounded-lg transition-colors border border-transparent hover:border-amber-200" title="Edit">
                                            <span class="material-symbols-outlined text-[20px] block">edit_square</span>
                                        </button>
                                        
                                        <!-- Form Delete -->
                                        <form action="{{ route('editor.audio.langgam.destroy', $langgam->id) }}" method="POST" onsubmit="return confirm('Yakin hapus langgam ini? Semua data relasinya akan hilang.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-700 hover:bg-rose-50 p-2 rounded-lg transition-colors border border-transparent hover:border-rose-200" title="Hapus">
                                                <span class="material-symbols-outlined text-[20px] block">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <span class="material-symbols-outlined text-5xl mb-3 opacity-50">library_music</span>
                                        <p class="text-sm font-medium">Belum ada data langgam.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL DYNAMIC (Create & Edit) -->
    <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Backdrop -->
        <div x-show="isModalOpen" x-transition.opacity.duration.300ms class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal()"></div>
        
        <!-- Modal Content -->
        <div x-show="isModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden flex flex-col max-h-[90vh]">
            
            <!-- Header Modal -->
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600" x-text="mode === 'create' ? 'add_circle' : 'edit_square'"></span>
                    <span x-text="mode === 'create' ? 'Tambah Langgam Baru' : 'Edit Data Langgam'"></span>
                </h3>
                <button @click="closeModal()" class="text-slate-400 hover:text-rose-500 hover:bg-rose-50 p-1 rounded-lg transition-colors">
                    <span class="material-symbols-outlined block">close</span>
                </button>
            </div>
            
            <!-- Form Body -->
            <form :action="formAction" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <!-- Override method ke PUT secara dinamis jika sedang edit -->
                <input type="hidden" name="_method" :value="mode === 'edit' ? 'PUT' : 'POST'">
                
                <div class="p-6 space-y-6 overflow-y-auto">
                    <!-- Input Nama -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Langgam</label>
                        <input type="text" name="nama" x-model="nama" required class="w-full rounded-xl border-slate-300 bg-slate-50 py-2.5 px-4 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition-all outline-none" placeholder="Contoh: Bayati, Rost, Nahawand">
                    </div>

                    <!-- Input Qari (Checkboxes) -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Qari (Pelantun) yang Menguasai</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($qaris as $qari)
                            <label class="cursor-pointer">
                                <!-- Bind value checkbox ke array selectedQaris milik Alpine -->
                                <input type="checkbox" name="qari_ids[]" value="{{ $qari->id }}" class="peer hidden" x-model="selectedQaris">
                                <div class="rounded-xl border-2 border-slate-200 bg-white py-2.5 px-3 text-sm font-bold text-slate-500 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 hover:border-emerald-200 transition-all flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[18px]">mic</span>
                                    <span class="truncate">{{ $qari->nama }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-[11px] font-semibold text-slate-400 mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">info</span> Bisa pilih lebih dari satu.
                        </p>
                    </div>

                    <!-- Input Deskripsi -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Deskripsi Ringkas (Opsional)</label>
                        <textarea name="deskripsi" x-model="deskripsi" rows="3" class="w-full rounded-xl border-slate-300 bg-slate-50 py-3 px-4 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition-all outline-none" placeholder="Contoh: Irama lembut dan menenangkan..."></textarea>
                    </div>
                </div>

                <!-- Footer Modal -->
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                    <button type="button" @click="closeModal()" class="px-5 py-2.5 rounded-xl font-bold text-sm text-slate-600 hover:bg-slate-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-sm text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm active:scale-95 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        <span x-text="mode === 'create' ? 'Simpan Langgam' : 'Update Langgam'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    function langgamManager() {
        return {
            isModalOpen: false,
            mode: 'create', // 'create' atau 'edit'
            formAction: '',
            baseUrl: '{{ url("editor/audio/langgam") }}', // Base URL untuk route resource
            nama: '',
            deskripsi: '',
            selectedQaris: [], // Array ID untuk Alpine x-model

            openCreate() {
                this.mode = 'create';
                this.formAction = this.baseUrl; // Method POST otomatis ke route store
                this.nama = '';
                this.deskripsi = '';
                this.selectedQaris = [];
                this.isModalOpen = true;
            },

            openEdit(id, nama, deskripsi, qarisArray) {
                this.mode = 'edit';
                this.formAction = `${this.baseUrl}/${id}`; // Method PUT via hidden input
                this.nama = nama;
                this.deskripsi = deskripsi || '';
                
                // Ubah semua ID Qari menjadi string agar cocok strict match dengan value="" di input Blade
                this.selectedQaris = qarisArray.map(String); 
                
                this.isModalOpen = true;
            },

            closeModal() {
                this.isModalOpen = false;
            }
        }
    }
</script>
@endsection