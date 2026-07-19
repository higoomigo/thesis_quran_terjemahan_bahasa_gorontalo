<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usulan;
use App\Models\UsulanChat;
use App\Models\UsulanVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ValidasiChatController extends Controller
{
    /**
     * Tampilkan halaman ruang diskusi
     */
    public function show($id)
    {
        $usulan = Usulan::with([
            'ayat',
            'assignments.user',
            'chats' => function ($q) {
                $q->with('user')->orderBy('created_at', 'asc');
            },
            'votes'
        ])->findOrFail($id);

        // Cek apakah user terdaftar sebagai validator untuk usulan ini
        $isValidator = $usulan->assignments->contains('user_id', Auth::id());

        if (!$isValidator) {
            abort(403, 'Anda tidak memiliki akses ke ruang diskusi ini');
        }

        // Cek apakah tim sudah lengkap (3 pakar)
        if ($usulan->assignments->count() < 3) {
            return redirect()->route('admin.validasi.index')
                ->with('error', 'Tim validator belum lengkap. Menunggu ' . (3 - $usulan->assignments->count()) . ' pakar lagi.');
        }

        // Cek apakah sudah kadaluarsa
        $isExpired = $usulan->batas_waktu_diskusi && now()->gt($usulan->batas_waktu_diskusi);

        // Cek apakah user sudah voting
        $userVote = $usulan->votes->where('user_id', Auth::id())->first();

        // Hitung voting terkini
        $voteCounts = [
            'setuju' => $usulan->votes->where('keputusan', 'setuju')->count(),
            'tolak' => $usulan->votes->where('keputusan', 'tolak')->count(),
            'total' => $usulan->votes->count()
        ];

        // Cek apakah voting selesai (3 suara masuk)
        $votingComplete = $voteCounts['total'] >= 3;
        $title = "Ruang Diskusi - " . ($usulan->ayat->surah->nama_latin ?? 'Surah') . ":" . ($usulan->ayat->nomor_ayat ?? '');
        return view('admin.validasi.chat', compact(
            'usulan',
            'isExpired',
            'userVote',
            'voteCounts',
            'votingComplete',
            'title'
        ));
    }

    /**
     * Kirim pesan ke ruang diskusi
     */
    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'pesan' => 'required|string|max:1000'
        ]);

        $usulan = Usulan::findOrFail($id);

        // Verifikasi akses
        $isValidator = $usulan->assignments->contains('user_id', Auth::id());
        if (!$isValidator) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Cek apakah usulan sudah selesai
        if (in_array($usulan->status, ['diterima', 'ditolak'])) {
            return response()->json(['error' => 'Diskusi sudah selesai'], 400);
        }

        $chat = UsulanChat::create([
            'usulan_id' => $id,
            'user_id' => Auth::id(),
            'pesan' => $request->pesan,
            'is_system_message' => false
        ]);

        $chat->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Pesan terkirim',
            'data' => [
                'id' => $chat->id,
                'pesan' => $chat->pesan,
                'user_name' => $chat->user->name,
                'created_at' => $chat->created_at->diffForHumans(),
                'is_self' => true
            ]
        ]);
    }

    /**
     * Memulai sesi voting (system message)
     */
    public function triggerVoting($id)
    {
        $usulan = Usulan::with('assignments')->findOrFail($id);

        // Verifikasi akses
        $isValidator = $usulan->assignments->contains('user_id', Auth::id());
        if (!$isValidator) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Cek apakah tim sudah lengkap
        if ($usulan->assignments->count() < 3) {
            return response()->json(['error' => 'Tim validator belum lengkap'], 400);
        }

        // Cek apakah sudah kadaluarsa
        if ($usulan->batas_waktu_diskusi && now()->gt($usulan->batas_waktu_diskusi)) {
            return response()->json(['error' => 'Waktu diskusi sudah habis'], 400);
        }

        // Cek apakah sudah ada voting yang dimulai
        $existingVoting = UsulanChat::where('usulan_id', $id)
            ->where('is_system_message', true)
            ->where('pesan', 'LIKE', '%Sesi pemungutan suara telah dimulai%')
            ->exists();

        if ($existingVoting) {
            return response()->json(['error' => 'Sesi voting sudah dimulai sebelumnya'], 400);
        }

        // Buat pesan sistem
        $chat = UsulanChat::create([
            'usulan_id' => $id,
            'user_id' => Auth::id(),
            'pesan' => '🗳️ **Sesi pemungutan suara telah dimulai**\n\nSilakan pilih keputusan Anda: "Setuju" atau "Tolak" pada card di bawah ini.',
            'is_system_message' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sesi voting dimulai',
            'data' => [
                'id' => $chat->id,
                'pesan' => $chat->pesan,
                'created_at' => $chat->created_at->diffForHumans(),
                'is_system_message' => true
            ]
        ]);
    }

    /**
     * Menyimpan voting pakar
     */
    public function castVote(Request $request, $id)
    {
        $request->validate([
            'keputusan' => 'required|in:setuju,tolak'
        ]);

        $usulan = Usulan::with(['assignments', 'votes'])->findOrFail($id);

        // 1. Verifikasi Akses & Validasi Dasar
        $isValidator = $usulan->assignments->contains('user_id', Auth::id());
        if (!$isValidator) {
            return response()->json(['error' => 'Unauthorized. Anda bukan validator di usulan ini.'], 403);
        }

        // Cek apakah status masih 'menunggu'
        if ($usulan->status !== 'menunggu') {
            return response()->json(['error' => 'Sesi voting untuk usulan ini sudah ditutup.'], 400);
        }

        // Cek apakah waktu sudah habis
        if ($usulan->batas_waktu_diskusi && now()->gt($usulan->batas_waktu_diskusi)) {
            return response()->json(['error' => 'Waktu diskusi sudah habis.'], 400);
        }

        // Cek apakah user sudah voting
        $existingVote = $usulan->votes->where('user_id', Auth::id())->first();
        if ($existingVote) {
            return response()->json(['error' => 'Anda sudah memberikan suara.'], 400);
        }

        // 2. Kunci dengan Database Transaction (Mencegah Race Condition / Bentrok)
        DB::beginTransaction();
        try {
            // Simpan vote
            $vote = UsulanVote::create([
                'usulan_id' => $id,
                'user_id' => Auth::id(),
                'keputusan' => $request->keputusan
            ]);

            // Kirim pesan sistem bahwa user ini baru saja voting
            $voteMessage = UsulanChat::create([
                'usulan_id' => $id,
                'user_id' => Auth::id(),
                'pesan' => "📊 **" . Auth::user()->name . "** memberikan suara: **" . strtoupper($request->keputusan) . "**",
                'is_system_message' => true
            ]);

            // 3. Hitung Ulang Votes Langsung dari DB (Paling Akurat)
            $setujuCount = UsulanVote::where('usulan_id', $id)->where('keputusan', 'setuju')->count();
            $tolakCount  = UsulanVote::where('usulan_id', $id)->where('keputusan', 'tolak')->count();
            $totalVotes  = $setujuCount + $tolakCount;

            $voteCounts = [
                'setuju' => $setujuCount,
                'tolak'  => $tolakCount,
                'total'  => $totalVotes
            ];

            $votingComplete = $totalVotes >= 3;
            $result = null;

            // 4. JIKA VOTING SELESAI (SUARA KE-3 MASUK) -> UPDATE TABEL USULAN_TERJEMAHANS
            if ($votingComplete) {
                $finalDecision = ($setujuCount >= 2) ? 'diterima' : 'ditolak';

                // ---> INI EKSEKUSI UPDATE KE TABEL USULAN_TERJEMAHANS <---
                $usulan->status = $finalDecision;
                $usulan->validated_at = now(); // Ngisi kolom yang barusan kita migrate
                $usulan->save();

                // (Opsional) Update status di tabel usulan_assignments menjadi 'selesai'
                $usulan->assignments()->update(['status' => 'selesai']);

                // Kirim pesan sistem hasil akhir
                $resultMessage = $finalDecision == 'diterima'
                    ? "🎉 **KEPUTUSAN FINAL: USULAN DITERIMA** 🎉\n\nMayoritas suara ($setujuCount dari 3) menyetujui usulan ini. Menunggu proses selanjutnya di Meja Editor."
                    : "📌 **KEPUTUSAN FINAL: USULAN DITOLAK** 📌\n\nMayoritas suara ($tolakCount dari 3) menolak usulan ini. Usulan diarsipkan.";

                UsulanChat::create([
                    'usulan_id' => $id,
                    'user_id' => Auth::id(),
                    'pesan' => $resultMessage,
                    'is_system_message' => true
                ]);

                $result = [
                    'final_decision' => $finalDecision,
                    'vote_counts' => $voteCounts
                ];
            }

            DB::commit(); // Simpan semua perubahan ke database

            return response()->json([
                'success' => true,
                'message' => 'Suara berhasil disimpan',
                'vote_counts' => $voteCounts,
                'voting_complete' => $votingComplete,
                'result' => $result,
                'vote_message' => [
                    'id' => $voteMessage->id,
                    'pesan' => $voteMessage->pesan,
                    'created_at' => $voteMessage->created_at->diffForHumans()
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua aksi jika terjadi error
            return response()->json(['error' => 'Terjadi kesalahan sistem saat menyimpan suara: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Ambil pesan terbaru (untuk polling)
     */
    public function getNewMessages(Request $request, $id)
    {
        $lastId = $request->last_id ?? 0;

        $messages = UsulanChat::with('user')
            ->where('usulan_id', $id)
            ->where('id', '>', $lastId)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'pesan' => $msg->pesan,
                    'is_system_message' => $msg->is_system_message,
                    'user_name' => $msg->user?->name,
                    'user_id' => $msg->user_id,
                    'created_at' => $msg->created_at->diffForHumans(),
                    'is_self' => $msg->user_id == Auth::id()
                ];
            });

        return response()->json([
            'messages' => $messages,
            'last_id' => $messages->last()['id'] ?? $lastId
        ]);
    }

    /**
     * Menyimpan Draf Kesimpulan Final dari Panel Ahli (Validator)
     */
    public function submitFinal(Request $request, $id)
    {
        $usulan = Usulan::findOrFail($id);

        // 1. UPDATE GEMBOK KEAMANAN
        if (!in_array($usulan->status, ['diterima', 'ditolak'])) {
            return back()->with('error', 'Akses ditolak! Usulan belum mencapai mufakat (diterima/ditolak) oleh Panelis.');
        }

        // 2. VALIDASI DINAMIS (Beda status, beda syarat)
        $rules = [
            'alasan_revisi' => 'required|string',
            'catatan_pakar' => 'nullable|string',
        ];

        // Teks rekomendasi (draf final) HANYA wajib kalau usulan diterima
        if ($usulan->status == 'diterima') {
            $rules['teks_rekomendasi'] = 'required|string';
        }

        $validated = $request->validate($rules);

        // 3. SIMPAN DATA
        // Kalau ditolak, pastiin teks_rekomendasi diset null biar database bersih
        $usulan->update([
            'teks_rekomendasi' => $usulan->status == 'diterima' ? $validated['teks_rekomendasi'] : null,
            'alasan_revisi'    => $validated['alasan_revisi'],
            'catatan_pakar'    => $validated['catatan_pakar'] ?? null,
            // Opsional: Kalau lu mau nandain kapan ini disahkan pakar
            // 'validated_at'  => now(), 
        ]);

        return redirect()->back()->with('success', 'Laporan final berhasil dikirim ke Redaksi!');
    }
}
