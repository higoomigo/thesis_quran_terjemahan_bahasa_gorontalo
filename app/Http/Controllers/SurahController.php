<?php

namespace App\Http\Controllers;

use App\Models\AudioArab;
use App\Models\AudioGorontalo;
use App\Models\Surah;
use App\Models\Ayat;
use App\Models\Langgam;
use App\Models\Pelantun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SurahController extends Controller
{
    /**
     * Display a listing of the resouSurahe.
     */
    public function index()
    {
        // 1. Ambil semua surah beserta ayatnya (Pastikan eager loading jalan)
        $surahs = Surah::with('ayats')->orderBy('no_surah', 'asc')->get();

        // 2. Persiapkan Data Keterangan Juz di Controller
        $allAyats = $surahs->pluck('ayats')->flatten();
        $ayatsByJuz = $allAyats->groupBy('juz');

        $juzData = [];

        // Looping untuk Juz 1 sampai 30
        for ($i = 1; $i <= 30; $i++) {
            $juzAyats = $ayatsByJuz->get($i);
            $keterangan = "Belum ada data ayat";

            if ($juzAyats && $juzAyats->isNotEmpty()) {
                // Urutkan ayat secara matematis (Surah x 1000 + Ayat) untuk memastikan urutan mutlak
                $juzAyats = $juzAyats->sortBy(function ($ayat) {
                    return ($ayat->no_surah * 1000) + $ayat->nomorAyat;
                })->values();

                $first = $juzAyats->first();
                $last  = $juzAyats->last();

                // Cari nama surah (karena $surahs sudah ditarik di awal, pencarian ini tidak nembak database lagi)
                $firstSurah = $surahs->firstWhere('no_surah', $first->no_surah);
                $lastSurah  = $surahs->firstWhere('no_surah', $last->no_surah);

                if ($firstSurah && $lastSurah) {
                    $keterangan = "{$firstSurah->nama_latin} : {$first->nomorAyat} — {$lastSurah->nama_latin} : {$last->nomorAyat}";
                }
            }

            // Masukkan ke array sebagai object agar mudah dipanggil di Blade
            $juzData[] = (object) [
                'id' => $i,
                'keterangan' => $keterangan
            ];
        }

        // 3. Lempar $surahs dan $juzData ke View
        return view('all_surah', compact('surahs', 'juzData'));
    }

    public function show($id)
    {
        // 1. Ambil data Surah utama beserta ayat, footnote, dan audionya sekaligus
        $surah = Surah::with([
            'ayats.footnotes',
            'ayats.audioArabs',
            'ayats.audioGorontalos'
        ])->where('no_surah', $id)->firstOrFail();

        // 2. Ambil semua surah untuk ditampilkan di menu sidebar
        $allSurahs = Surah::orderBy('no_surah', 'asc')->get();

        // 3. Ambil data Langgam yang HANYA relevan dengan surah ini
        $langgams = Langgam::whereIn('id', function($query) use ($surah) {
            $query->select('langgam_id')
                  ->from('audio_arabs')
                  ->join('ayats', 'ayats.id', '=', 'audio_arabs.ayat_id')
                  ->where('ayats.no_surah', $surah->no_surah)
                  ->whereNotNull('langgam_id');
        })->get();

        // 4. Ambil data Pelantun Gorontalo yang HANYA relevan dengan surah ini
        $pembacaGorontalo = Pelantun::whereIn('id', function($query) use ($surah) {
            $query->select('pembaca_gorontalo_id')
                  ->from('audio_gorontalos')
                  ->join('ayats', 'ayats.id', '=', 'audio_gorontalos.ayat_id')
                  ->where('ayats.no_surah', $surah->no_surah);
        })->get();

        // 5. Ambil data Surah Sebelumnya (Prev) dan Selanjutnya (Next) untuk navigasi bawah
        $prevSurah = Surah::where('no_surah', '<', $surah->no_surah)->orderBy('no_surah', 'desc')->first();
        $nextSurah = Surah::where('no_surah', '>', $surah->no_surah)->orderBy('no_surah', 'asc')->first();
        
        // 6. Masukkan daftar ayat ke variabel $ayats untuk dipakai di Blade
        $ayats = $surah->ayats;

        // 7. Ambil daftar Qari untuk default state (Opsional, tapi biar nggak error kalau qaris kosong di blade)
        $qaris = Pelantun::select('id', 'nama')->get();

        // Variabel default untuk dropdown agar tidak error Undefined Variable di Blade
        $langgamId = request('langgam_id', '');
        $qariId = request('qari_id', '');
        $pembacaGorontaloId = request('pembaca_gorontalo_id', '');

        // 8. Kirim semua variabel ke tampilan View
        return view('surah.show', compact(
            'surah', 
            'ayats', 
            'allSurahs', 
            'prevSurah', 
            'nextSurah', 
            'langgams', 
            'pembacaGorontalo',
            'qaris',
            'langgamId',
            'qariId',
            'pembacaGorontaloId'
        ));
    }

    public function showJuz($juz_id)
    {
        // Validasi Juz 1-30
        if ($juz_id < 1 || $juz_id > 30) {
            abort(404, 'Juz tidak ditemukan');
        }

        // Ambil semua ayat di Juz ini, urutkan berdasarkan ID/Nomor urut mutlak, beserta data Surahnya
        $ayats = \App\Models\Ayat::with(['surah', 'audioArabs', 'audioGorontalos'])
            ->where('juz', $juz_id)
            ->orderBy('id', 'asc') // Asumsi ID tabel ayat lu urut dari Al-Fatihah 1 sampai An-Nas 6
            ->get();

        if ($ayats->isEmpty()) {
            abort(404, 'Belum ada data ayat untuk Juz ini.');
        }

        // Bikin navigasi prev/next Juz
        $prevJuz = $juz_id > 1 ? $juz_id - 1 : null;
        $nextJuz = $juz_id < 30 ? $juz_id + 1 : null;

        return view('surah.juz', compact('ayats', 'juz_id', 'prevJuz', 'nextJuz'));
    }

    public function getAudioFilter(\Illuminate\Http\Request $request)
    {
        $surah_id = $request->surah_id;
        $langgam_id = $request->langgam_id;
        $qari_id = $request->qari_id;
        $pembaca_gorontalo_id = $request->pembaca_gorontalo_id;

        $response = [];

        // ====================================================
        // 1. CARI QARI BERDASARKAN LANGGAM & SURAH (ANTI-BUG)
        // ====================================================
        if ($request->has('langgam_id')) {
            if ($langgam_id) {
                // Langsung ngintip ke tabel audio_arabs, gak usah lewat relasi pivot!
                $response['qaris'] = \App\Models\Pelantun::whereIn('id', function($query) use ($surah_id, $langgam_id) {
                    $query->select('pelantun_id')
                          ->from('audio_arabs')
                          ->join('ayats', 'ayats.id', '=', 'audio_arabs.ayat_id')
                          ->where('ayats.no_surah', $surah_id)
                          ->where('audio_arabs.langgam_id', $langgam_id);
                })->select('id', 'nama')->get();
            } else {
                $response['qaris'] = [];
            }
        }

        // ====================================================
        // 2. AMBIL AUDIO ARAB SESUAI QARI & LANGGAM
        // ====================================================
        if ($qari_id && $surah_id) {
            $audioLinksArab = [];
            $ayats = \App\Models\Ayat::where('no_surah', $surah_id)->get(['id', 'nomorAyat']);
            
            foreach ($ayats as $ayat) {
                $audioQuery = \App\Models\AudioArab::where('ayat_id', $ayat->id)
                                ->where('pelantun_id', $qari_id);
                
                // Pastikan audionya sesuai langgam yang dipilih
                if ($langgam_id) {
                    $audioQuery->where('langgam_id', $langgam_id);
                }

                $audio = $audioQuery->first();
                
                if ($audio) {
                    // Sapu bersih kata 'public/' kalau nyangkut di database
                    $cleanPath = preg_replace('/^public\//', '', $audio->file_path);
                    $audioLinksArab[$ayat->nomorAyat] = asset('storage/' . ltrim($cleanPath, '/'));
                } else {
                    $audioLinksArab[$ayat->nomorAyat] = '';
                }
            }
            $response['audioLinksArab'] = $audioLinksArab;
        }

        // ====================================================
        // 3. AMBIL AUDIO GORONTALO
        // ====================================================
        if ($pembaca_gorontalo_id && $surah_id) {
            $audioLinksGoro = [];
            $ayats = \App\Models\Ayat::where('no_surah', $surah_id)->get(['id', 'nomorAyat']);
            
            foreach ($ayats as $ayat) {
                $audio = \App\Models\AudioGorontalo::where('ayat_id', $ayat->id)
                            ->where('pembaca_gorontalo_id', $pembaca_gorontalo_id)
                            ->first();
                            
                if ($audio) {
                    // Sapu bersih kata 'public/'
                    $cleanPath = preg_replace('/^public\//', '', $audio->file_path);
                    $audioLinksGoro[$ayat->nomorAyat] = asset('storage/' . ltrim($cleanPath, '/'));
                } else {
                    $audioLinksGoro[$ayat->nomorAyat] = '';
                }
            }
            $response['audioLinksGoro'] = $audioLinksGoro;
        }

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resouSurahe.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resouSurahe in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resouSurahe.
     */
    // public function show(Surah $Surah)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resouSurahe.
     */
    public function edit(Surah $Surah)
    {
        //
    }

    /**
     * Update the specified resouSurahe in storage.
     */
    public function update(Request $request, Surah $Surah)
    {
        //
    }

    /**
     * Remove the specified resouSurahe from storage.
     */
    public function destroy(Surah $Surah)
    {
        //
    }
}
