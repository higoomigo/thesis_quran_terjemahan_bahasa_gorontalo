<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ThreadController extends Controller
{
    /**
     * TAMPILAN DEPAN FORUM (index.blade.php)
     */
    public function index(Request $request)
    {
        // Ambil semua kategori untuk Sidebar
        $categories = Category::all();

        // Mulai query dengan relasi user & category, serta hitung jumlah balasan
        $query = Thread::with(['user:id,name,avatar', 'category'])->withCount('replies');

        // 1. FILTER PENCARIAN (Search Bar)
        $query->when($request->search, function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('body', 'like', '%' . $request->search . '%');
            });
        });

        // 2. FILTER KATEGORI (Dari Sidebar)
        $query->when($request->kategori, function ($q) use ($request) {
            $q->whereHas('category', function ($subQuery) use ($request) {
                $subQuery->where('slug', $request->kategori);
            });
        });

        // 3. FILTER STATUS (Dari Sidebar)
        // Filter Status (Dari Sidebar)
        $query->when($request->filter, function ($q) use ($request) {
            $filter = $request->filter;
            
            if ($filter === 'saya' && Auth::check()) {
                // Bungkus pakai function() biar "OR" nya nggak bentrok sama filter kategori/search
                $q->where(function ($sub) {
                    $sub->where('user_id', Auth::id()) // 1. Diskusi yang dia bikin sendiri
                        ->orWhereHas('replies', function ($replyQuery) {
                            $replyQuery->where('user_id', Auth::id()); // 2. ATAU diskusi orang lain yang dia ikut komen
                        });
                });
            } 
            elseif ($filter === 'belum_terjawab') {
                $q->doesntHave('replies'); // Diskusi yang komentarnya masih 0
            } 
            elseif ($filter === 'selesai') {
                $q->where('is_solved', true); // Diskusi yang sudah ada "Jawaban Terbaik"
            }
        });

        // 4. SORTING / PENGURUTAN (Dari Dropdown Atas)
        $sort = $request->sort ?? 'latest'; // Default: Terbaru

        if ($sort === 'popular') {
            $query->orderByDesc('replies_count'); // Paling banyak dibalas
        } elseif ($sort === 'views') {
            $query->orderByDesc('views'); // Paling banyak dilihat
        } else {
            $query->latest(); // Urutan default (terbaru dibuat)
        }

        // 5. Eksekusi query (Pake withQueryString biar kalau pindah halaman, filternya gak keriset)
        $threads = $query->paginate(15)->withQueryString();

        return view('forum.index', compact('threads', 'categories'));
    }

    /**
     * HALAMAN FORM BIKIN DISKUSI (create.blade.php)
     */
    public function create()
    {
        $categories = Category::all();
        return view('forum.create', compact('categories'));
    }

    /**
     * PROSES SIMPAN DISKUSI KE DATABASE
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'body'        => 'required|string|min:10',
        ]);

        $slug = Str::slug($validated['title']) . '-' . Str::random(6);

        $thread = Thread::create([
            'user_id'     => Auth::id(),
            'category_id' => $validated['category_id'],
            'title'       => $validated['title'],
            'slug'        => $slug,
            'body'        => $validated['body'],
        ]);

        return redirect()->route('forum.thread.show', $thread->slug)
            ->with('success', 'Diskusi baru berhasil dibuat!');
    }

    /**
     * HALAMAN DETAIL DISKUSI & KOMENTAR (show.blade.php)
     */
    public function show($slug)
    {
        // PENTING: Variabelnya $thread (TUNGGAL)
        $thread = Thread::with(['user', 'category'])->where('slug', $slug)->firstOrFail();

        $sessionKey = 'viewed_thread_' . $thread->id;
        if (!session()->has($sessionKey)) {
            $thread->increment('views');
            session()->put($sessionKey, true);
        }

        // PENTING: Variabel balasan namanya $replies
        $replies = $thread->replies()->with('user')->oldest()->paginate(20);

        $categories = Category::all();

        return view('forum.show', compact('thread', 'replies', 'categories'));
    }

    public function destroy($id)
    {
        // Cari diskusi berdasarkan ID
        $thread = \App\Models\Thread::findOrFail($id);

        // Satpam Keamanan: Cek apakah user adalah Admin ATAU pemilik thread
        if (auth()->user()->role !== 'admin' && auth()->id() !== $thread->user_id) {
            return back()->with('error', 'Akses ditolak! Anda bukan admin atau pemilik diskusi ini.');
        }

        // Eksekusi hapus
        $thread->delete();

        // Redirect ke halaman utama forum karena thread-nya udah musnah
        return redirect()->route('forum.index')->with('success', 'Diskusi berhasil dihapus secara permanen!');
    }
}
