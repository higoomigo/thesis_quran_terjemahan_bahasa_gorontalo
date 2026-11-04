<?php

namespace App\Http\Controllers;

use App\Models\AudioArab;
use App\Models\AudioGorontalo;
use Illuminate\Http\Request;

class AudioController extends Controller
{   


    public function getAudioUrl($ayat_id, $jenis, Request $request)
    {
        if ($jenis === 'arab') {
            $audio = AudioArab::where('ayat_id', $ayat_id)
                ->when($request->langgam_id, fn($q) => $q->where('langgam_id', $request->langgam_id))
                ->when($request->qari_id, fn($q) => $q->where('qari_id', $request->qari_id))
                ->first();
        } else {
            $audio = AudioGorontalo::where('ayat_id', $ayat_id)
                ->when($request->pembaca_id, fn($q) => $q->where('pembaca_gorontalo_id', $request->pembaca_id))
                ->first();
        }

        if (!$audio) {
            return response()->json(['error' => 'Audio tidak ditemukan'], 404);
        }

        return response()->json([
            'url' => asset('storage/' . $audio->file_path)
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
