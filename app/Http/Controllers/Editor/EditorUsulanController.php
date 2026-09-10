<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Usulan;
use Illuminate\Http\Request;

class EditorUsulanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
{
    // Bisa diatur via URL misal: ?per_page=50, defaultnya 20
    $perPage = request('per_page', 20);

    $usulan = Usulan::with(['ayat', 'assignments.user'])
        ->when(request('status'), function ($query) {
            // JIKA ADA filter status (misal admin klik tab 'diterima')
            return $query->where('status', request('status'));
        }, function ($query) {
            // JIKA TIDAK ADA filter status (tampilan default semua data)
            // KUNCI PERBAIKAN: Sembunyikan yang 'diarsipkan' DAN 'dipublikasi' sekaligus
            return $query->whereNotIn('status', ['menunggu_validasi', 'dipublikasi']);
        })
        ->when(request('search'), function ($query) {
            // Gunakan grouping agar kondisi OR tidak membocorkan filter status
            return $query->where(function ($q) {
                $q->where('nama_pengusul', 'like', '%' . request('search') . '%')
                    ->orWhere('usulan_teks', 'like', '%' . request('search') . '%');
            });
        })
        ->latest()
        ->paginate($perPage)
        ->withQueryString(); // KUNCI UTAMA: Menjaga filter tetap aktif saat pindah halaman

    $statusCount = [
        'menunggu' => Usulan::where('status', 'menunggu')->count(),
        'diterima' => Usulan::where('status', 'diterima')->count(),
        'ditolak' => Usulan::where('status', 'ditolak')->count(),
        // 'dipublikasi' => Usulan::where('status', 'dipublikasi')->count(),
        // 'diarsipkan' => Usulan::where('status', 'diarsipkan')->count(),
    ];

    $title = "Daftar Usulan | Admin Panel - Qur'an Gorontalo";
    return view('editor.usulan.index', compact('usulan', 'statusCount', 'title'));
}

    public function show($id)
    {
        try {
            // Kuncinya ditambahin 'assignments.user' di sini bang!
            $usulan = Usulan::with(['ayat.surah', 'assignments.user'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $usulan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $usulan = Usulan::findOrFail($id);
        $usulan->delete();

        return redirect()->route('admin.usulan.index')->with('success', 'Usulan berhasil dihapus');
    }

    // Fungsi Arsip
    public function arsip($id)
    {
        $usulan = Usulan::findOrFail($id);
        // Ubah statusnya jadi 'diarsipkan' (pastikan ini dibolehin di database lu)
        $usulan->update(['status' => 'diarsipkan']);

        return back()->with('success', 'Usulan berhasil diarsipkan.');
    }

    public function accept($id)
    {
        $usulan = Usulan::findOrFail($id);
        // Ubah statusnya jadi 'menunggu_validasi' (pastikan ini dibolehin di database lu)
        $usulan->update(['status' => 'menunggu_validasi']);

        return back()->with('success', 'Usulan diteruskan ke antrean validasi.');
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
    
}
