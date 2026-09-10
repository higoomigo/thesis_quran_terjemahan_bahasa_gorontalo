<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surah;
use App\Models\Ayat;
use App\Models\Pelantun;
use App\Models\Langgam;
use App\Models\AyatAudio;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\File;

class AudioAyatController extends Controller
{
    /**
     * 1. Menampilkan Halaman Daftar Surah (Index)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query dengan fitur pencarian dan pagination
        $surahs = Surah::orderBy('no_surah', 'asc')
            ->when($search, function ($query, $search) {
                return $query->where('nama_latin', 'like', "%{$search}%")
                             ->orWhere('arti', 'like', "%{$search}%");
            })
            ->paginate(15) // Tampilkan 15 data per halaman
            ->withQueryString();
        // Return ke view index yang nanti kita buat (mirip kayak data-terjemahan)
        return view('editor.audio.ayat.index', compact('surahs'));
    }

    /**
     * 2. Menampilkan Halaman Detail Ayat & Form Upload di dalam Surah (Show)
     */
    public function show($surah_id, Request $request)
    {
        $surah = Surah::with('ayats')->findOrFail($surah_id);
    
        // 1. Ambil semua Langgam, TAPI sertakan (eager load) Qari yang berelasi dengannya
        $langgams = Langgam::with(['pelantuns' => function($query) {
            $query->whereIn('peran', ['qari', 'keduanya']);
        }])->get();

        // 2. Pembaca Gorontalo (karena ga pake langgam, tarik normal aja)
        $pembacas = Pelantun::whereIn('peran', ['pembaca_terjemahan', 'keduanya'])->get();

        // Kita ga perlu tarik $qaris terpisah lagi, karena udah "nempel" di dalam $langgams
        return view('editor.audio.ayat.show', compact('surah', 'langgams', 'pembacas'));
    }

    /**
     * 3. Fungsi Upload Massal via ZIP
     */
   public function storeZip(Request $request, $surah_id)
    {
        $request->validate([
            'jenis_zip' => 'required|in:arab,gorontalo',
            'langgam_id' => 'required_if:jenis_zip,arab|nullable|exists:langgams,id',
            'qari_id' => 'required_if:jenis_zip,arab|nullable|exists:pelantuns,id',
            'pembaca_gorontalo_id' => 'required_if:jenis_zip,gorontalo|nullable|exists:pelantuns,id',
            'file_zip' => 'required|mimes:zip|max:102400', 
        ]);

        $surah = Surah::findOrFail($surah_id);
        $zipFile = $request->file('file_zip');

        $tempDir = storage_path('app/temp/zip_' . time());
        File::makeDirectory($tempDir, 0755, true, true);

        $zip = new ZipArchive;
        if ($zip->open($zipFile->path()) === TRUE) {
            $zip->extractTo($tempDir);
            $zip->close();

            $files = File::files($tempDir);
            $berhasil = 0;

            foreach ($files as $file) {
                $filename = $file->getFilename(); 
                $nomorAyat = (int) pathinfo($filename, PATHINFO_FILENAME);

                $ayat = Ayat::where('no_surah', $surah->no_surah)->where('nomorAyat', $nomorAyat)->first();

                if ($ayat) {
                    $folderDestinasi = 'audio/ayat/' . $request->jenis_zip;
                    $namaFileBaru = $surah->no_surah . '_' . $nomorAyat . '_' . time() . '.mp3';
                    $pathStorage = $folderDestinasi . '/' . $namaFileBaru;
                    Storage::disk('public')->put($pathStorage, File::get($file));

                    // PISAHKAN LOGIKA ARAB DAN GORONTALO
                    if ($request->jenis_zip == 'arab') {
                        \App\Models\AyatAudio::updateOrCreate(
                            ['ayat_id' => $ayat->id, 'langgam_id' => $request->langgam_id],
                            ['qari_id' => $request->qari_id, 'file_path_arab' => $pathStorage]
                        );
                    } else {
                        // Gorontalo disimpan dengan langgam_id = null
                        \App\Models\AyatAudio::updateOrCreate(
                            ['ayat_id' => $ayat->id, 'langgam_id' => null],
                            ['pembaca_gorontalo_id' => $request->pembaca_gorontalo_id, 'file_path_gorontalo' => $pathStorage]
                        );
                    }
                    $berhasil++;
                }
            }
            File::deleteDirectory($tempDir);
            return back()->with('success', "Berhasil menyimpan $berhasil audio!");
        } else {
            File::deleteDirectory($tempDir);
            return back()->with('error', 'Gagal membuka file ZIP.');
        }
    }

    // public function storeSingle(Request $request, $surah_id)
    // {
    //     $request->validate([
    //         'ayat_id' => 'required|exists:ayats,id',
    //         'jenis_audio' => 'required|in:arab,gorontalo',
    //         'langgam_id' => 'required_if:jenis_audio,arab|nullable|exists:langgams,id',
    //         'qari_id' => 'required_if:jenis_audio,arab|nullable|exists:pelantuns,id',
    //         'pembaca_gorontalo_id' => 'required_if:jenis_audio,gorontalo|nullable|exists:pelantuns,id',
    //         'file_audio' => 'required|mimes:mp3|max:10240',
    //     ]);

    //     $ayat = Ayat::findOrFail($request->ayat_id);
    //     $surah = Surah::findOrFail($surah_id);
        
    //     $folderDestinasi = 'audio/ayat/' . $request->jenis_audio;
    //     $namaFileBaru = 'single_' . $surah->no_surah . '_' . $ayat->nomorAyat . '_' . time() . '.mp3';
        
    //     $pathStorage = $request->file('file_audio')->storeAs($folderDestinasi, $namaFileBaru, 'public');

    //     // PISAHKAN LOGIKA ARAB DAN GORONTALO
    //     if ($request->jenis_audio == 'arab') {
    //         \App\Models\AyatAudio::updateOrCreate(
    //             ['ayat_id' => $ayat->id, 'langgam_id' => $request->langgam_id],
    //             ['qari_id' => $request->qari_id, 'file_path_arab' => $pathStorage]
    //         );
    //     } else {
    //         // Gorontalo disimpan dengan langgam_id = null
    //         \App\Models\AyatAudio::updateOrCreate(
    //             ['ayat_id' => $ayat->id, 'langgam_id' => null],
    //             ['pembaca_gorontalo_id' => $request->pembaca_gorontalo_id, 'file_path_gorontalo' => $pathStorage]
    //         );
    //     }

    //     return back()->with('success', 'Audio untuk Ayat ke-' . $ayat->nomorAyat . ' berhasil diperbarui!');
    // }

    /**
     * 4. Fungsi Upload Eceran (1 Ayat Saja) untuk Revisi/Perbaikan
     */
    public function storeSingle(Request $request, $ayat_id)
    {
        // dd($request->all());
        $request->validate([
            'jenis_audio' => 'required|in:arab,gorontalo',
            
            // Wajib diisi HANYA JIKA jenis_audio adalah 'arab'
            'langgam_id' => 'required_if:jenis_audio,arab',
            'qari_id'    => 'required_if:jenis_audio,arab',
            
            // Wajib diisi HANYA JIKA jenis_audio adalah 'gorontalo'
            'pembaca_gorontalo_id' => 'required_if:jenis_audio,gorontalo',
            
            'file_audio' => 'required|mimes:mp3|max:10240' // contoh kalau file
        ],[
            // Custom pesan error biar enak dibaca
            'langgam_id.required_if' => 'Langgam wajib dipilih untuk audio Arab.',
            'qari_id.required_if' => 'Qari wajib dipilih untuk audio Arab.',
            'pembaca_gorontalo_id.required_if' => 'Pembaca wajib dipilih untuk audio Gorontalo.'
        ]);

        if (!$request->qari_id && !$request->pembaca_gorontalo_id) {
            return back()->with('error', 'Pilih minimal satu Qari atau Pembaca Terjemahan!');
        }

        $ayat = Ayat::findOrFail($request->ayat_id);
        $surah = Surah::findOrFail($ayat_id);
        
        $folderDestinasi = 'audio/ayat/' . $request->jenis_audio;
        $namaFileBaru = $surah->no_surah . '_' . $ayat->nomorAyat . '_' . time() . '.mp3';
        
        $pathStorage = $request->file('file_audio')->storeAs($folderDestinasi, $namaFileBaru, 'public');

        // $ayatAudio = new AyatAudio();

        // $dataUpdate = [];
        // if ($request->jenis_audio == 'arab' && $request->qari_id) {
        //     $kondisiPencarian['qari_id'] = $request->qari_id;
        //     $dataUpdate['file_path_arab'] = $pathStorage;
        // } elseif ($request->jenis_audio == 'gorontalo' && $request->pembaca_gorontalo_id) {
        //     $kondisiPencarian['pembaca_gorontalo_id'] = $request->pembaca_gorontalo_id;
        //     $dataUpdate['file_path_gorontalo'] = $pathStorage;
        // }

        if($request->jenis_audio == 'arab'){
            AyatAudio::updateOrCreate(
                ['id' => $request->audio_id], // Jika ada ID audio, update; jika tidak, buat baru
                [
                    'ayat_id' => $ayat->id,
                    // 'langgam_id' => $request->langgam_id,
                    'qari_id' => $request->qari_id,
                    // 'pembaca_gorontalo_id' => $request->pembaca_gorontalo_id,
                    'file_path_arab' => $request->jenis_audio == 'arab' ? $pathStorage : null,
                    // 'file_path_gorontalo' => $request->jenis_audio == 'gorontalo' ? $pathStorage : null,
                ]
            );
        } elseif($request->jenis_audio == 'gorontalo'){
            AyatAudio::updateOrCreate(
                ['id' => $request->audio_id], // Jika ada ID audio, update; jika tidak, buat baru
                [
                    'ayat_id' => $ayat->id,
                    'langgam_id' => $request->langgam_id,
                    // 'qari_id' => $request->qari_id,
                    'pembaca_gorontalo_id' => $request->pembaca_gorontalo_id,
                    // 'file_path_arab' => $request->jenis_audio == 'arab' ? $pathStorage : null,
                    'file_path_gorontalo' => $request->jenis_audio == 'gorontalo' ? $pathStorage : null,
                ]
            );
        }
        

        return back()->with('success', 'Audio untuk Ayat ke-' . $ayat->nomorAyat . ' berhasil diperbarui!');
         // Hanya untuk testing, nanti diganti dengan redirect back
    }
}