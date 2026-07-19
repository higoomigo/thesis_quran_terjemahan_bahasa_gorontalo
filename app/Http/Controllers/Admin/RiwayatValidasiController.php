<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usulan;
use Illuminate\Http\Request;

class RiwayatValidasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Hitung statistik status (sama seperti di controller lain)
        $statusCount = [
            'menunggu' => Usulan::where('status', 'menunggu')->count(),
            'diterima' => Usulan::where('status', 'diterima')->count(),
            'ditolak'  => Usulan::where('status', 'ditolak')->count(),
        ];

        // Query riwayat
        $riwayat = Usulan::with([
                'ayat.surah',
                'assignments.user',
                'votes'
            ])
            ->whereIn('status', ['diterima', 'ditolak', 'dipublikasi'])
            ->orderBy('validated_at', 'desc')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('usulan_teks', 'like', "%{$search}%")
                    ->orWhere('nama_pengusul', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString();

        // Kirim kedua variabel ke view
        return view('admin.validasi.history', compact('riwayat', 'statusCount'));
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
