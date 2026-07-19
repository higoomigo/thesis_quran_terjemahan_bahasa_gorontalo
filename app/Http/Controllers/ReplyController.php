<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    /**
     * Simpan balasan baru ke database
     */
    public function store(Request $request, $thread_id)
    {
        // Validasi komentar nggak boleh kosong
        $validated = $request->validate([
            'body' => 'required|string|min:2',
        ]);

        // Pastikan thread-nya beneran ada
        $thread = Thread::findOrFail($thread_id);

        // Simpan komentar
        Reply::create([
            'user_id'   => Auth::id(),
            'thread_id' => $thread->id,
            'body'      => $validated['body'],
        ]);

        return redirect()->back()->with('success', 'Balasan berhasil dikirim!');
    }

    public function destroy($id)
    {
        // Sesuaikan dengan nama Model balasan lu (misal: Reply, ThreadReply, atau ForumReply)
        $reply = \App\Models\Reply::findOrFail($id);

        // Satpam Keamanan: Cek apakah user adalah Admin ATAU pemilik komentar
        if (auth()->user()->role !== 'admin' && auth()->id() !== $reply->user_id) {
            return back()->with('error', 'Akses ditolak! Anda tidak memiliki izin menghapus balasan ini.');
        }

        // Eksekusi hapus
        $reply->delete();

        // Karena cuma hapus balasan, kita balikin user ke halaman diskusi yang sama
        return back()->with('success', 'Balasan berhasil dihapus!');
    }
}