<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usulan;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Hanya tarik usulan yang statusnya 'diterima'
        $query = Usulan::with(['ayat.surah'])
            ->where('status', 'dipublikasi');

        // Fitur pencarian (opsional tapi sangat berguna)
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('usulan_teks', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pengusul', 'like', '%' . $request->search . '%');
            });
        }

        // Urutkan dari yang paling lama disetujui (First In, First Out)
        $antrean = $query->orderBy('validated_at', 'asc')->paginate(15);
        
        $title = "Antrean Publikasi | Editor Panel - Qur'an Gorontalo";

        return view('editor.riwayat.index', compact('antrean', 'title'));
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
    public function show(string $id)
    {
        //
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
