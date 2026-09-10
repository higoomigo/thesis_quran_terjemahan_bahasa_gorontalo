<?php
// app/Http/Controllers/Admin/UsulanController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usulan;
use App\Models\Ayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsulanAssignment;
use Carbon\Carbon;

class UsulanController extends Controller
{
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
            return $query->whereNotIn('status', ['menunggu','diarsipkan', 'dipublikasi']);
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
        'menunggu_validasi' => Usulan::where('status', 'menunggu_validasi')->count(),
        'diterima' => Usulan::where('status', 'diterima')->count(),
        'ditolak' => Usulan::where('status', 'ditolak')->count(),
        // 'dipublikasi' => Usulan::where('status', 'dipublikasi')->count(),
        // 'diarsipkan' => Usulan::where('status', 'diarsipkan')->count(),
    ];

    $title = "Daftar Usulan | Admin Panel - Qur'an Gorontalo";
    return view('admin.usulan.index', compact('usulan', 'statusCount', 'title'));
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

    public function claim($id)
    {
        // 1. Cari data usulan
        $usulan = Usulan::findOrFail($id);
        $user = Auth::user();

        // 2. Cek apakah usulan ini masih "menunggu"
        if ($usulan->status !== 'menunggu') {
            return response()->json(['success' => false, 'message' => 'Usulan ini sudah diproses.'], 400);
        }

        // 3. Cek apakah user ini sudah pernah mengklaim usulan yang sama
        $alreadyClaimed = UsulanAssignment::where('usulan_id', $usulan->id)
            ->where('user_id', $user->id)
            ->exists();
        if ($alreadyClaimed) {
            return response()->json(['success' => false, 'message' => 'Anda sudah berada di tim validator ini.'], 400);
        }

        // 4. Logika Kuota Berdasarkan Role
        // (Asumsi di tabel users lu sudah ada kolom 'role' berisi 'teologi' atau 'linguistik')
        $role = $user->role;

        $currentRoleCount = UsulanAssignment::where('usulan_id', $usulan->id)
            ->whereHas('user', function ($query) use ($role) {
                $query->where('role', $role);
            })->count();

        if ($role === 'teologi' && $currentRoleCount >= 2) {
            return response()->json(['success' => false, 'message' => 'Kuota pakar Teologi (Maks 2) sudah penuh.'], 400);
        }

        if ($role === 'linguistik' && $currentRoleCount >= 1) {
            return response()->json(['success' => false, 'message' => 'Kuota pakar Linguistik (Maks 1) sudah penuh.'], 400);
        }

        // 5. Masukkan user ke tim (Tabel Pivot)
        UsulanAssignment::create([
            'usulan_id' => $usulan->id,
            'user_id' => $user->id,
            'status' => 'aktif'
        ]);

        // 6. Cek apakah tim sudah lengkap (3 orang). Jika ya, set batas waktu diskusi
        $totalTeamMembers = UsulanAssignment::where('usulan_id', $usulan->id)->count();

        if ($totalTeamMembers === 3) {
            $usulan->batas_waktu_diskusi = Carbon::now()->addDays(14); // Set 2 minggu
            $usulan->save();
        }

        return response()->json(['success' => true, 'message' => 'Klaim berhasil.']);
    }

   
    private function getStatusBadge($status)
    {
        switch ($status) {
            case 'menunggu':
                return 'bg-yellow-100 text-yellow-800';
            case 'diterima':
                return 'bg-green-100 text-green-800';
            case 'ditolak':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    private function getStatusText($status)
    {
        switch ($status) {
            case 'menunggu':
                return 'Menunggu';
            case 'diterima':
                return 'Diterima';
            case 'ditolak':
                return 'Ditolak';
            default:
                return ucfirst($status);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $usulan = Usulan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:menunggu,diterima,ditolak',
            'catatan_pakar' => 'nullable|string|max:1000'
        ]);

        $usulan->update([
            'status' => $request->status,
            'catatan_pakar' => $request->catatan_pakar
        ]);

        return redirect()->back()->with('success', 'Status usulan berhasil diperbarui');
    }

    
}
