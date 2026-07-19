<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Ayat;
use App\Models\Surah;
use Illuminate\Http\Request;

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
