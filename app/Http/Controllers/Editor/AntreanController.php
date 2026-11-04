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
        try {
            DB::beginTransaction();

            $usulan = Usulan::findOrFail($id);
            $ayat   = Ayat::findOrFail($usulan->ayat_id);

            // ==========================================
            // 1. VALIDASI BERDASARKAN STATUS
            // ==========================================
            if ($usulan->status === 'diterima') {
                $request->validate([
                    'teks_final'    => 'required|string',
                    'alasan_revisi' => 'required|string',
                ]);
            } else {
                // Kalau ditolak, teks_final tidak wajib
                $request->validate([
                    'alasan_revisi' => 'required|string',
                ]);
            }

            // ==========================================
            // 2. JIKA DITERIMA → UPDATE TERJEMAHAN + RIWAYAT
            // ==========================================
            if ($usulan->status === 'diterima') {
                // Simpan riwayat sebelum ditimpa
                RiwayatTerjemahan::create([
                    'ayat_id'       => $ayat->id,
                    'usulan_id'     => $usulan->id,
                    'editor_id'     => auth()->id(),
                    'teks_lama'     => $ayat->teks_gorontalo,
                    'teks_baru'     => $request->teks_final,
                    'alasan_revisi' => $request->alasan_revisi,
                ]);

                // Update teks utama
                $ayat->update([
                    'teks_gorontalo' => $request->teks_final
                ]);
            }

            // ==========================================
            // 3. SELALU UPDATE STATUS JADI DIPUBLIKASI
            //    (baik diterima maupun ditolak)
            // ==========================================
            $usulan->update([
                'status'        => 'dipublikasi',
                'alasan_revisi' => $request->alasan_revisi, // simpan alasan dari form
            ]);

            DB::commit();

            return redirect()->route('editor.antrean.index')
                ->with('success', 'Alhamdulillah! Hasil validasi berhasil dipublikasikan.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
