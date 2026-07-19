<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Usulan;
use App\Models\Ayat;
use App\Models\RiwayatTerjemahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntreanController extends Controller
{
    /**
     * Menampilkan daftar usulan yang berstatus 'diterima'
     */
    public function index(Request $request)
    {
        // KUNCI PERBAIKAN: Gunakan whereIn, bukan where!
        $query = Usulan::with(['ayat.surah'])
            ->whereIn('status', ['diterima', 'ditolak']);

        // Fitur pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('usulan_teks', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_pengusul', 'like', '%' . $request->search . '%');
            });
        }

        // Urutkan dari yang paling lama masuk antrean (First In, First Out)
        // Aing tambahin withQueryString() biar kalau lu search dan pindah page, search-nya ga ilang
        $antrean = $query->orderBy('created_at', 'asc')->paginate(15)->withQueryString();

        $title = "Antrean Publikasi | Editor Panel - Qur'an Gorontalo";

        return view('editor.antrean.index', compact('antrean', 'title'));
    }

    /**
     * Menampilkan detail usulan dan form tinjauan Editor
     */
    public function show($id)
    {
        // Tarik data usulan berserta relasi ayat dan catatan tim validator
        $usulan = Usulan::with(['ayat.surah', 'assignments.user'])
            ->whereIn('status', ['diterima', 'ditolak'])
            ->findOrFail($id);

        $title = "Tinjau Usulan Publikasi | Editor Panel";

        return view('editor.antrean.show', compact('usulan', 'title'));
    }

    /**
     * EKSEKUSI FINAL: Publikasikan usulan dan timpa teks terjemahan di tabel Ayat
     */
    public function publikasi(Request $request, $id)
    {
        // 1. Validasi input dari form textarea Editor
        $request->validate([
            'teks_final' => 'required|string',
        ]);

        try {
            // Gunakan Transaction agar jika salah satu gagal, semua dibatalkan (anti-data-korup)
            DB::beginTransaction();

            $usulan = Usulan::findOrFail($id);

            // Keamanan lapis kedua: pastikan usulan memang berstatus 'diterima'


            $ayat = Ayat::findOrFail($usulan->ayat_id);

            // ==========================================
            // INI YANG HILANG BANG: ARSIPKAN KE BRANKAS SEJARAH
            // ==========================================
            RiwayatTerjemahan::create([
                'ayat_id'       => $ayat->id,
                'usulan_id'     => $usulan->id,
                'editor_id'     => auth()->id(), // Mencatat Editor siapa yang ngetuk palu
                'teks_lama'     => $ayat->teks_gorontalo, // Teks asli Gorontalo sebelum ditimpa
                'teks_baru'     => $request->teks_final,  // Teks final dari editor
                'alasan_revisi' => $usulan->alasan_revisi, // Ngunci alasan dari dewan pakar
            ]);

            // ==========================================
            // 2. UPDATE DATA UTAMA AL-QUR'AN
            // ==========================================
            $ayat->update([
                'teks_gorontalo' => $request->teks_final
            ]);

            // ==========================================
            // 3. TUTUP BUKU USULAN
            // ==========================================
            if ($usulan->status !== 'ditolak') {
                $usulan->update([
                    'status' => 'dipublikasi',
                    // Kita nggak menimpa usulan_teks biar sejarah ketikan asli masyarakat tetap utuh
                ]);
            }
            $usulan->update([
                'status' => 'dipublikasi',
                // Kita nggak menimpa usulan_teks biar sejarah ketikan asli masyarakat tetap utuh
            ]);

            DB::commit(); // Simpan semua perubahan permanen ke database

            return redirect()->route('editor.antrean.index')
                ->with('success', 'Alhamdulillah! Terjemahan berhasil dipublikasi dan riwayat telah diarsipkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            // MATIKAN KODE BAWAH SEMENTARA
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());

            // NYALAKAN X-RAY:
            // dd('ERRORNYA DI SINI BLAY:', $e->getMessage(), 'Di Baris:', $e->getLine());
        }
    }
}
