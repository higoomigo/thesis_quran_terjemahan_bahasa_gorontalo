<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Langgam;
use App\Models\Pelantun; // WAJIB TAMBAHIN INI BANG!

class LanggamController extends Controller
{
    public function index()
    {
        $langgams = Langgam::with('pelantuns')->orderBy('id', 'desc')->get();
    $qaris = Pelantun::whereIn('peran', ['qari', 'keduanya'])->get();
    
    return view('editor.audio.langgam.index', compact('langgams', 'qaris'));
    }

    public function create()
    {
        // Lempar data Qari buat di-looping jadi checkbox di halaman Create
        $qaris = Pelantun::whereIn('peran', ['qari', 'keduanya'])->get();
        return view('editor.audio.langgam.create', compact('qaris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'qari_ids' => 'nullable|array', // Validasi qari_ids harus berupa array dari checkbox
            'qari_ids.*' => 'exists:pelantuns,id' // Pastikan ID qari benar-benar ada di tabel pelantuns
        ]);

        // 1. Bikin data Langgam baru (Jangan pake all() biar array qari_ids gak ikut masuk ke insert)
        $langgam = Langgam::create($request->only(['nama', 'deskripsi']));

        // 2. Hubungkan ke Qari yang dicentang pakai sync()
        if ($request->has('qari_ids')) {
            $langgam->pelantuns()->sync($request->qari_ids);
        }

        return redirect()->route('editor.audio.langgam.index')->with('success', 'Langgam berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $langgam = Langgam::findOrFail($id);
        
        // Lempar data Qari buat nampilin checkbox beserta riwayat centangannya
        $qaris = Pelantun::whereIn('peran', ['qari', 'keduanya'])->get();
        
        return view('editor.audio.langgam.edit', compact('langgam', 'qaris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'qari_ids' => 'nullable|array',
            'qari_ids.*' => 'exists:pelantuns,id' 
        ]);

        $langgam = Langgam::findOrFail($id);
        
        // 1. Update nama dan deskripsi
        $langgam->update($request->only(['nama', 'deskripsi']));

        // 2. Sinkronisasi (Update) relasi Qari
        // Kasih fallback (?? []) biar kalau Admin ngelepas SEMUA centangan, 
        // Laravel akan ngehapus semua relasi qari di langgam tersebut.
        $langgam->pelantuns()->sync($request->qari_ids ?? []);

        return redirect()->route('editor.audio.langgam.index')->with('success', 'Data langgam berhasil diupdate!');
    }

    public function destroy($id)
    {
        // Kalau di migration pivot table lu udah pake ->onDelete('cascade'),
        // data relasi di tabel pivot bakal otomatis ikut bersih pas langgam dihapus.
        Langgam::findOrFail($id)->delete();
        return back()->with('success', 'Langgam berhasil dihapus!');
    }
}