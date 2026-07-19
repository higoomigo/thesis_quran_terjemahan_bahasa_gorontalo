<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * Nampilin halaman utama forum (Semua Thread)
     */
    public function index(Request $request)
    {
        // Ambil data kategori untuk sidebar
        $categories = Category::all();

        // Mulai Query Utama
        $query = Thread::with(['user', 'category'])->withCount('replies');

        // 1. Filter Kategori (Jika URL ada ?kategori=xxx)
        $query->when($request->has('kategori'), function ($q) use ($request) {
            $q->whereHas('category', function ($subQuery) use ($request) {
                $subQuery->where('slug', $request->kategori);
            });
        });

        // 2. Filter Status Diskusi (Jika URL ada ?filter=xxx)
        $query->when($request->has('filter'), function ($q) use ($request) {
            $filter = $request->filter;

            if ($filter === 'saya' && Auth::check()) {
                $q->where('user_id', Auth::id());
            } elseif ($filter === 'belum_terjawab') {
                $q->doesntHave('replies'); // Cari yang jumlah komentarnya 0
            } elseif ($filter === 'selesai') {
                // Asumsi lu ntar bikin kolom 'is_solved' atau 'best_reply_id' di tabel threads
                $q->where('is_solved', true);
            }
        });

        // Eksekusi query dengan paginasi
        $threads = $query->latest()->paginate(10);

        // Bawa kembali parameter query saat pindah halaman paginasi
        $threads->appends($request->query());

        return view('forum.index', compact('threads', 'categories'));
    }

    /**
     * Nampilin halaman forum tapi difilter berdasarkan Kategori tertentu
     */
    public function category($slug)
    {
        // Cari kategori berdasarkan slug-nya (misal: /forum/kategori/tata-bahasa)
        $category = Category::where('slug', $slug)->firstOrFail();

        // Tetap bawa semua kategori buat nampilin menu filter
        $categories = Category::all();

        // Tarik thread yang HANYA milik kategori tersebut
        $threads = Thread::where('category_id', $category->id)
            ->with(['user:id,name,avatar', 'category'])
            ->withCount('replies')
            ->latest()
            ->paginate(15);

        // Lempar ke view yang sama, tapi bawa variabel $category biar kita tau lagi di halaman filter
        return view('forum.index', compact('threads', 'categories', 'category'));
    }
}
