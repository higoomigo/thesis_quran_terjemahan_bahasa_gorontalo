<?php

namespace App\Http\Controllers;

use App\Models\AudioArab;
use App\Models\AudioGorontalo;
use App\Models\Surah;
use App\Models\Ayat;

use Illuminate\Http\Request;


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
                $juzAyats = $juzAyats->sortBy(function($ayat) {
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

    public function show($surahId)
    {
       try {
            // Find surah by no_surah
            $surah = Surah::where('no_surah', $surahId)->firstOrFail();
            
            // Get all ayats for this surah, ordered by ayat number
            $ayats = Ayat::where('no_surah', $surahId)
                        ->orderBy('nomorAyat', 'asc')
                        ->get();
            
            // Get all surahs for the sidebar
            $allSurahs = Surah::orderBy('no_surah', 'asc')->get();
            
            // Get previous surah
            $prevSurah = Surah::where('no_surah', '<', $surahId)
                              ->orderBy('no_surah', 'desc')
                              ->first();
            
            // Get next surah
            $nextSurah = Surah::where('no_surah', '>', $surahId)
                              ->orderBy('no_surah', 'asc')
                              ->first();
            
            // Get user bookmarks if authenticated
            // $bookmarks = [];
            // if (auth()->check()) {
            //     $bookmarks = Bookmark::where('user_id', auth()->id())
            //                          ->orderBy('created_at', 'desc')
            //                          ->get();
            
            $audioArab = AudioArab::whereIn('ayat_id', $ayats->pluck('id'))->get();
            $audioGorontalo = AudioGorontalo::whereIn('ayat_id', $ayats->pluck('id'))->get();

            // Return the view with all data
            return view('surah.show', compact(
                'surah', 
                'ayats', 
                'allSurahs', 
                'prevSurah', 
                'nextSurah', 
                'audioArab',
                'audioGorontalo',
                // 'bookmarks'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error showing surah: ' . $e->getMessage());
            return redirect()->route('mushaf')
                           ->with('error', 'Surah tidak ditemukan');
        }
        
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
