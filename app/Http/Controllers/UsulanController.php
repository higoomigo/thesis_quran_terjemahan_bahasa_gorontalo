<?php
// app/Http/Controllers/UsulanController.php

namespace App\Http\Controllers;

use App\Models\Ayat;
use App\Models\RiwayatTerjemahan;
use App\Models\Surah;
use App\Models\Usulan;
use App\Models\UsulanAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UsulanController extends Controller
{
    /**
     * Menampilkan halaman usulan untuk ayat tertentu
     */
   public function index($surah_id, $ayat_id)
    {
        // 1. CARI BERDASARKAN no_surah, BUKAN id
        $data_surah = Surah::where('no_surah', $surah_id)->firstOrFail();

        // 2. CARI AYAT BERDASARKAN nomorAyat DAN surah_id
        $data_ayat = Ayat::with(['usulan' => function ($query) {
            $query->where('status', '!=', 'dipublikasi')->latest();
        }])
        ->where('no_surah', $data_surah->no_surah) // CATATAN: Kalau foreign key lu di tabel ayat namanya no_surah, ubah jadi $data_surah->no_surah
        ->where('nomorAyat', $ayat_id)
        ->firstOrFail();

        // 3. AMBIL RIWAYAT BERDASARKAN ayat_id
        $riwayat_terjemahans = RiwayatTerjemahan::with([
            'editor:id,name',
            'usulan',
            'usulan.assignments.user:id,name'
        ])
        ->where('ayat_id', $data_ayat->id)
        ->latest()
        ->get();

        return view('usulan_guest.index', compact('data_surah', 'data_ayat', 'riwayat_terjemahans'));
    }
    /**
     * Menyimpan usulan terjemahan baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'ayat_id' => 'required|exists:ayats,id',
            'nama_pengusul' => 'required|string|max:100|min:2',
            'no_hp' => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'usulan_teks' => 'required|string|min:10|max:5000',
        ], [
            'nama_pengusul.required' => 'Nama lengkap wajib diisi.',
            'nama_pengusul.min' => 'Nama minimal 2 karakter.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Format nomor HP tidak valid.',
            'usulan_teks.required' => 'Usulan terjemahan wajib diisi.',
            'usulan_teks.min' => 'Usulan terjemahan minimal 10 karakter.',
        ]);

        try {
            DB::beginTransaction();

            // Simpan usulan
            $usulan = Usulan::create([
                'ayat_id' => $validated['ayat_id'],
                'nama_pengusul' => $validated['nama_pengusul'],
                'no_hp' => $validated['no_hp'],
                'usulan_teks' => $validated['usulan_teks'],
                'status' => '',
            ]);

            DB::commit();

            // Ambil data ayat untuk redirect
            $ayat = Ayat::find($validated['ayat_id']);

            return redirect()
                ->route('usulan.index', [
                    'surah_id' => $ayat->no_surah,
                    'ayat_id' => $ayat->nomorAyat
                ])
                ->with('success', 'Terima kasih! Usulan Anda telah kami terima dan akan segera direview oleh tim pakar kami.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan usulan: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Maaf, terjadi kesalahan sistem. Silakan coba lagi nanti.');
        }
    }

    
}
