<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usulan;
use App\Models\UsulanVote;
use App\Models\UsulanChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

            // ---------------------------------------------------------
            // 1. STATISTIK CEPAT
            // ---------------------------------------------------------
 
            // 🔹 TOTAL DIKLAIM: semua usulan yang di-assign ke validator ini
            //    pakai whereHas('assignments') buat filter relasi pivot/assignment
            $totalDiklaim = Usulan::whereHas('assignments', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->count();

            // 🔹 MENUNGGU: assigned + status menunggu + BELUM vote
            //    whereDoesntHave = "tidak punya relasi votes dengan user_id ini"
            $menungguValidasi = Usulan::where('status', 'menunggu_validasi')
                ->whereHas('assignments', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->whereDoesntHave('votes', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->count();

            // 🔹 SUDAH DIVOTE: hitung dari tabel votes langsung
            $telahDivalidasi = UsulanVote::where('user_id', $userId)->count();

            // 🔹 DITERIMA: assigned + status akhir 'diterima'
            $usulanDiterima = Usulan::where('status', 'diterima')
                ->whereHas('assignments', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->count();

            // 🔹 DITOLAK: assigned + status akhir 'ditolak'
            $usulanDitolak = Usulan::where('status', 'ditolak')
                ->whereHas('assignments', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->count();

            // 🔹 Persentase persetujuan
            $totalSelesai = $usulanDiterima + $usulanDitolak;
            $persetujuan = $totalSelesai > 0
                ? round(($usulanDiterima / $totalSelesai) * 100)
                : 0;

            $statistik = [
                'total_diklaim' => $totalDiklaim,   // ⬅️ BARU
                'menunggu'      => $menungguValidasi,
                'divote'        => $telahDivalidasi,
                'diterima'      => $usulanDiterima, // ⬅️ BARU
                'ditolak'       => $usulanDitolak,  // ⬅️ BARU
                'persetujuan'   => $persetujuan,
            ];

        // ---------------------------------------------------------
        // 2. ANTREAN TUGAS PRIORITAS (Berdasarkan Deadline Terdekat)
        // ---------------------------------------------------------
        // Ambil data yang DIA BELUM VOTE, urutkan dari batas_waktu_diskusi paling mepet
        $antreanPrioritas = Usulan::with(['ayat.surah'])
            ->where('status', 'menunggu_validasi')
            ->whereHas('assignments', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereDoesntHave('votes', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orderBy('batas_waktu_diskusi', 'asc') // Yang mau expired duluan naik ke atas
            ->paginate(5, ['*'], 'antrean_page'); // Pakai custom page name biar nggak bentrok

        // ---------------------------------------------------------
        // 3. AKTIVITAS DISKUSI TERBARU (Feed Obrolan & Sistem)
        // ---------------------------------------------------------
        // Ambil chat dari usulan-usulan yang di-assign ke validator ini
        $aktivitasTerbaru = UsulanChat::with(['user', 'usulan.ayat.surah'])
            ->whereHas('usulan.assignments', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('created_at', '>=', now()->subDays(3))
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // ---------------------------------------------------------
        // 4. RIWAYAT VALIDASI TERAKHIR (Recent History)
        // ---------------------------------------------------------
        // 5 usulan terakhir yang baru saja di-vote oleh user ini
        $riwayatValidasi = UsulanVote::with(['usulan.ayat.surah'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $title = "Validator Dashboard | Qur'an Gorontalo";

        return view('dashboard', compact(
            'title', 
            'statistik', 
            'antreanPrioritas', 
            'aktivitasTerbaru', 
            'riwayatValidasi'
        ));
    }
}

