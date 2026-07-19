<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usulan;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        
        $query = Usulan::with(['ayat.surah']);
        
        // Filter berdasarkan status
        if ($request->status && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan pencarian
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('usulan_teks', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pengusul', 'like', '%' . $request->search . '%')
                  ->orWhere('no_hp', 'like', '%' . $request->search . '%')
                  ->orWhereHas('ayat', function($q2) use ($request) {
                      $q2->where('nomorAyat', 'like', '%' . $request->search . '%')
                         ->orWhereHas('surah', function($q3) use ($request) {
                             $q3->where('nama_latin', 'like', '%' . $request->search . '%');
                         });
                  });
            });
        }
        
        // Filter berdasarkan rentang waktu
        if ($request->date_from && $request->date_to) {
            $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }
        
        $usulan = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Statistik untuk dashboard
        $statusCount = [
            'menunggu' => Usulan::where('status', 'menunggu')->count(),
            'diterima' => Usulan::where('status', 'diterima')->count(),
            'ditolak' => Usulan::where('status', 'ditolak')->count(),
            'total' => Usulan::count()
        ];
        
        // Hitung persentase perubahan dari minggu lalu
        $lastWeekCount = Usulan::whereBetween('created_at', [now()->subWeek(), now()])->count();
        $percentageChange = $statusCount['total'] > 0 ? round(($statusCount['total'] - $lastWeekCount) / max(1, $lastWeekCount) * 100) : 0;
        
        // Usulan prioritas per surah
        $priorityUsulan = Usulan::where('status', 'menunggu')
            ->whereHas('ayat.surah', function($q) {
                $q->where('no_surah', 2); // Al-Baqarah
            })
            ->count();
        $title = "Dashboard | Admin Panel - Qur'an Gorontalo";
        return view('dashboard', compact('usulan', 'statusCount', 'percentageChange', 'priorityUsulan' , 'title'));
    }
}
