<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usulan;
use App\Models\Ayat;
use App\Models\UsulanAssignment;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Hitung total usulan yang siap ditinjau Editor (status: diterima)
        $totalAntrean = Usulan::where('status', 'diterima')->count();

        // 2. Hitung total usulan yang sudah berhasil ditayangkan Editor (status: dipublikasi)
        $totalPublikasi = Usulan::where('status', 'dipublikasi')->count();

        // 3. Hitung total keseluruhan ayat yang sudah memiliki teks terjemahan bahasa Gorontalo
        // Asumsinya nama model lu Ayat dan nama kolomnya teks_gorontalo
        $totalAyatGorontalo = Ayat::whereNotNull('teks_gorontalo')->count();
        $tim = UsulanAssignment::whereHas('usulan', function ($query) {
                                $query->where('status', 'menunggu');
                           })->distinct('user_id')->count('user_id');

        // 4. Tarik 5 usulan terbaru yang masuk ke meja redaksi untuk tabel ringkasan
        $antreanTerbaru = Usulan::with(['ayat.surah'])
            ->where('status', 'diterima')
            ->orderBy('validated_at', 'desc') // Diurutkan berdasarkan waktu disetujui pakar
            ->take(5)
            ->get();

        // Title halaman buat tag <title> di head HTML
        $title = "Dashboard Editor | Admin Panel - Qur'an Gorontalo";

        // Lempar semua variabel ke view editor.dashboard
        return view('editor.dashboard', compact(
            'totalAntrean', 
            'totalPublikasi', 
            'totalAyatGorontalo', 
            'antreanTerbaru', 
            'title',
            'tim'
        ));
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
