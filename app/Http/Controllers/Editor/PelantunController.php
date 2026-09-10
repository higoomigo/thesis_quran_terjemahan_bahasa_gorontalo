<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelantun;

class PelantunController extends Controller
{
    public function index()
    {
        $pelantuns = Pelantun::orderBy('id', 'desc')->get();
        return view('editor.audio.pelantun.index', compact('pelantuns'));
    }

    public function create()
    {
        return view('editor.audio.pelantun.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'peran' => 'required|in:qari,pembaca_terjemahan,keduanya',
            'deskripsi' => 'nullable|string'
        ]);

        Pelantun::create($request->all());
        return redirect()->route('editor.audio.pelantun.index')->with('success', 'Pelantun berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pelantun = Pelantun::findOrFail($id);
        return view('editor.audio.pelantun.edit', compact('pelantun'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'peran' => 'required|in:qari,pembaca_terjemahan,keduanya',
            'deskripsi' => 'nullable|string'
        ]);

        Pelantun::findOrFail($id)->update($request->all());
        return redirect()->route('editor.audio.pelantun.index')->with('success', 'Data pelantun berhasil diupdate!');
    }

    public function destroy($id)
    {
        Pelantun::findOrFail($id)->delete();
        return back()->with('success', 'Pelantun berhasil dihapus!');
    }
}