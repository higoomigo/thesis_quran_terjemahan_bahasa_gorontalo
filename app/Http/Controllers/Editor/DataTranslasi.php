<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Ayat;
use App\Models\Surah;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class DataTranslasi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surahs = Surah::all();
        return view('editor.data-translasi.index', compact('surahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    // Tambahkan parameter $surah_id yang dilempar dari Route lu
    public function storeCsv(Request $request, $surah_id)
    {
        $request->validate([
            'file_csv' => 'required|file|mimes:csv,txt|max:10240',
        ], [
            'file_csv.required' => 'File CSV wajib diunggah!',
            'file_csv.mimes'    => 'File harus berekstensi .csv!'
        ]);

        $file = $request->file('file_csv');
        $handle = fopen($file->getRealPath(), 'r');
        
        if ($handle !== FALSE) {
            // Skip Header
            fgetcsv($handle, 1000, ',');

            $berhasil = 0;
            $gagal_validasi = 0;

            DB::beginTransaction();
            try {
                while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    if (count($row) >= 3) {
                        $csv_surah_id   = trim($row[0]);
                        $nomorAyat      = trim($row[1]);
                        $teks_gorontalo = trim($row[2]);

                        // 1. VALIDASI CROSS-CHECK: Pastikan ID Surah di CSV SAMA dengan ID Surah di URL
                        if ($csv_surah_id != $surah_id) {
                            $gagal_validasi++;
                            continue; // Abaikan baris ini, lanjut ke baris berikutnya
                        }

                        // 2. Eksekusi jika cocok dan teks tidak kosong
                        if (is_numeric($nomorAyat) && $teks_gorontalo !== '') {
                            
                            $updated = Ayat::where('no_surah', $surah_id) // Pakai surah_id dari URL agar lebih aman
                                ->where('nomorAyat', $nomorAyat)
                                ->update(['teks_gorontalo' => $teks_gorontalo]);

                            if ($updated) {
                                $berhasil++;
                            }
                        }
                    }
                }

                fclose($handle);

                // Jika ternyata SEMUA isi CSV salah surah (Human Error fatal)
                if ($berhasil == 0 && $gagal_validasi > 0) {
                    DB::rollBack();
                    return back()->with('error', 'Upload dibatalkan! Isi CSV tidak cocok dengan Surah yang sedang dibuka.');
                }

                DB::commit(); 
                
                $pesan = "Berhasil mengimpor $berhasil terjemahan.";
                if ($gagal_validasi > 0) {
                    $pesan .= " (Ada $gagal_validasi baris diabaikan karena beda Surah).";
                }

                return back()->with('success', $pesan);

            } catch (\Exception $e) {
                fclose($handle);
                DB::rollBack();
                return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
            }
        }

        return back()->with('error', 'Sistem gagal membaca file CSV Anda.');
    }

    /**
     * Display the specified resource.
     */
    public function show($no_surah)
    {
        // Ambil data surah beserta seluruh ayatnya
        $surah = Surah::where('no_surah', $no_surah)->firstOrFail();
        $ayats = Ayat::where('no_surah', $surah->no_surah)->orderBy('nomorAyat', 'asc')->get();

        return view('editor.data-translasi.show', compact('surah', 'ayats'));
    }

    // Fungsi untuk nge-save (opsional, disesuaikan dengan route lu)
    public function updateAyat(Request $request, $id)
    {
        $request->validate(['teks_gorontalo' => 'required|string']);
        
        $ayat = Ayat::findOrFail($id);
        $ayat->update(['teks_gorontalo' => $request->teks_gorontalo]);

        // Redirect kembali ke ayat tersebut agar layarnya nggak lompat ke atas
        return redirect()->to(url()->previous() . '#ayat-' . $ayat->nomorAyat)
                         ->with('success', 'Terjemahan Ayat ke-' . $ayat->nomorAyat . ' berhasil disimpan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
