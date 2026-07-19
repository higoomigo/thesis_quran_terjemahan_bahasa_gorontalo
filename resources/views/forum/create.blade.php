@extends('forum.layout')

@section('forum.content')
    
    <div class="mb-6">
        <a href="{{ route('forum.index') }}" class="inline-flex items-center gap-1.5 text-emerald-700 hover:text-emerald-800 font-semibold text-sm transition-colors bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Daftar Diskusi
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8 max-w-3xl">
        
        <h1 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-2 pb-4 border-b border-slate-100">
            <span class="material-symbols-outlined text-emerald-700">edit_square</span>
            Mulai Diskusi Baru
        </h1>

        <form action="{{ route('forum.thread.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="category_id" class="block text-sm font-bold text-slate-700 mb-2">Kategori Topik <span class="text-red-500">*</span></label>
                <select id="category_id" name="category_id" class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-3 border" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') 
                    <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Diskusi <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Arti kosakata 'Hulondalo' dalam perspektif budaya..." class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-3 border" required>
                @error('title') 
                    <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label for="body" class="block text-sm font-bold text-slate-700 mb-2">Isi Pertanyaan / Pemikiran Anda <span class="text-red-500">*</span></label>
                <textarea id="body" name="body" rows="8" placeholder="Tuliskan detail argumen, pertanyaan, atau referensi kitab yang ingin didiskusikan..." class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-4 border" required>{{ old('body') }}</textarea>
                @error('body') 
                    <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p> 
                @enderror
            </div>

            <div class="flex justify-end pt-6 border-t border-slate-100">
                <button type="submit" class="bg-emerald-700 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-emerald-800 transition-colors shadow-sm flex items-center gap-2 active:scale-95">
                    <span class="material-symbols-outlined">send</span> Publikasikan Diskusi
                </button>
            </div>
            
        </form>
    </div>

@endsection