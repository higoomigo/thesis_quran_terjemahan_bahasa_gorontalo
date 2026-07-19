<?php

namespace App\Http\Controllers;

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
        $surahs = Surah::all();
        return view('all_surah', compact('surahs'));

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
            
            
            // Return the view with all data
            return view('surah.show', compact(
                'surah', 
                'ayats', 
                'allSurahs', 
                'prevSurah', 
                'nextSurah', 
                // 'bookmarks'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error showing surah: ' . $e->getMessage());
            return redirect()->route('mushaf')
                           ->with('error', 'Surah tidak ditemukan');
        }
        
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
