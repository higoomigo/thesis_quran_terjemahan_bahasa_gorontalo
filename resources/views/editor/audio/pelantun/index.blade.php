@extends('layouts.app_editor')

@section('title', 'Master Pelantun')

@section('content')
<main class="flex-1 ml-64 px-6 py-8 bg-gray-50/50 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Master Pelantun</h2>
                <p class="text-gray-600 text-sm mt-1">Kelola data Qari dan Pembaca Terjemahan Gorontalo.</p>
            </div>
            <a href="{{ route('editor.audio.pelantun.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-bold text-sm transition-all shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add</span> Tambah Pelantun
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-100 shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">check_circle</span> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 border-b border-gray-200 text-xs uppercase tracking-wider">
                        <th class="px-6 py-3 font-bold w-12 text-center">No</th>
                        <th class="px-6 py-3 font-bold">Nama Pelantun</th>
                        <th class="px-6 py-3 font-bold">Peran</th>
                        <th class="px-6 py-3 font-bold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pelantuns as $pelantun)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 text-center text-sm font-bold text-gray-400">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">
                                <p class="text-sm font-bold text-gray-800">{{ $pelantun->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $pelantun->deskripsi ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-3">
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-md bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    {{ str_replace('_', ' ', $pelantun->peran) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center flex justify-center gap-2">
                                <a href="{{ route('editor.audio.pelantun.edit', $pelantun->id) }}" class="text-blue-500 hover:text-blue-700 bg-blue-50 p-1.5 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-[18px] block">edit</span>
                                </a>
                                <form action="{{ route('editor.audio.pelantun.destroy', $pelantun->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pelantun ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 p-1.5 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-[18px] block">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada data pelantun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection