<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidasiController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        $usulan = Usulan::with(['ayat', 'assignments.user'])
            ->whereHas('assignments', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($request->search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('usulan_teks', 'like', "%{$search}%")
                      ->orWhere('nama_pengusul', 'like', "%{$search}%")
                      ->orWhereHas('ayat', function($sq) use ($search) {
                          $sq->where('nama_surah', 'like', "%{$search}%")
                             ->orWhere('nomor_ayat', 'like', "%{$search}%");
                      });
                });
            })
            ->when($request->sort === 'terlama', function($query) {
                $query->orderBy('created_at', 'asc');
            }, function($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->paginate(10)
            ->withQueryString();
        
        foreach ($usulan as $item) {
            $item->total_pakar = $item->assignments->count();
            $item->tim_lengkap = $item->total_pakar >= 3; // Balikin ke 3
            $item->is_expired = $item->batas_waktu_diskusi ? now()->gt($item->batas_waktu_diskusi) : false;
            $item->sisa_hari = $item->batas_waktu_diskusi && !$item->is_expired 
                ? max(0, now()->diffInDays($item->batas_waktu_diskusi, false)) 
                : 0;
        }
        
        $statistics = [
            'total_antrean' => Usulan::whereHas('assignments', fn($q) => $q->where('user_id', $userId))->count(),
            'total_selesai' => Usulan::whereHas('assignments', fn($q) => $q->where('user_id', $userId))->whereIn('status', ['diterima', 'ditolak'])->count(),
            'total_expired' => Usulan::whereHas('assignments', fn($q) => $q->where('user_id', $userId))->where('batas_waktu_diskusi', '<', now())->where('status', 'menunggu')->count(),
            'hari_ini' => Usulan::whereHas('assignments', fn($q) => $q->where('user_id', $userId))->whereDate('created_at', today())->count(),
            'prioritas' => Usulan::whereHas('assignments', fn($q) => $q->where('user_id', $userId))->where('status', 'menunggu')->where('batas_waktu_diskusi', '<=', now()->addDays(3))->where('batas_waktu_diskusi', '>', now())->count(),
        ];
        
        return view('admin.validasi.index', compact('usulan', 'statistics'));
    }

    public function show($id)
    {
        $usulan = Usulan::with(['ayat.surah', 'assignments.user'])->findOrFail($id);
        return response()->json(['success' => true, 'data' => $usulan]);
    }
}