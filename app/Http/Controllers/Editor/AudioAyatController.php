<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surah;
use App\Models\Ayat;
use App\Models\Pelantun;
use App\Models\Langgam;
use App\Models\AudioArab;
use App\Models\AudioGorontalo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;

class AudioAyatController extends Controller
{
    /**
     * 1. Halaman daftar Surah
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $surahs = Surah::orderBy('no_surah', 'asc')
            ->when($search, function ($query, $search) {
                return $query->where('nama_latin', 'like', "%{$search}%")
                             ->orWhere('arti', 'like', "%{$search}%");
            })
            ->paginate(15)
            ->withQueryString();

        return view('editor.audio.ayat.index', compact('surahs'));
    }

    /**
     * 2. Halaman detail ayat + form upload di dalam Surah
     */
    public function show(Request $request, $surah_id)
    {
        $surah = Surah::with('ayats')->findOrFail($surah_id);

        $langgams = Langgam::with(['pelantuns' => function ($query) {
            $query->whereIn('peran', ['qari', 'keduanya']);
        }])->get();

        $pembacas = Pelantun::whereIn('peran', ['pembaca_terjemahan', 'keduanya'])->get();
        // $qaris = Pelantun::whereIn('peran', ['qari'])->get();
        
        // Filter yang dikirim dari form
        $langgamId           = $request->langgam_id;
        $qariId              = $request->pelantun_id;
        $pembacaGorontaloId  = $request->pembaca_gorontalo_id;
        // dd($langgamId, $qariId, $pembacaGorontaloId);
        return view('editor.audio.ayat.show', compact(
            'surah',
            'langgams',
            'pembacas',
            // 'qaris',
            'langgamId',
            'qariId',
            'pembacaGorontaloId'
        ));
    }

    /**
     * 3. Upload massal via ZIP
     */
    public function storeZip(Request $request, $surah_id)
    {
        $request->validate([
            'jenis_zip'              => 'required|in:arab,gorontalo',
            'langgam_id'             => 'required_if:jenis_zip,arab|nullable|exists:langgams,id',
            'pelantun_id'                => 'required_if:jenis_zip,arab|nullable|exists:pelantuns,id',
            'pembaca_gorontalo_id'   => 'required_if:jenis_zip,gorontalo|nullable|exists:pelantuns,id',
            'file_zip'               => 'required|mimes:zip|max:102400',
        ]);

        $surah = Surah::findOrFail($surah_id);
        $zipFile = $request->file('file_zip');

        $tempDir = storage_path('app/temp/zip_' . time());
        File::makeDirectory($tempDir, 0755, true, true);

        $zip = new ZipArchive;
        if ($zip->open($zipFile->path()) !== true) {
            File::deleteDirectory($tempDir);
            return back()->with('error', 'Gagal membuka file ZIP.');
        }

        $zip->extractTo($tempDir);
        $zip->close();

        $files = File::files($tempDir);
        $berhasil = 0;

        foreach ($files as $file) {
            $filename   = $file->getFilename();
            $nomorAyat  = (int) pathinfo($filename, PATHINFO_FILENAME);

            $ayat = Ayat::where('no_surah', $surah->no_surah)
                        ->where('nomorAyat', $nomorAyat)
                        ->first();

            if (!$ayat) {
                continue;
            }

            $folderDestinasi = 'audio/ayat/' . $request->jenis_zip;
            $namaFileBaru    = $surah->no_surah . '_' . $nomorAyat . '_' . time() . '.mp3';
            $pathStorage     = $folderDestinasi . '/' . $namaFileBaru;

            Storage::disk('public')->put($pathStorage, File::get($file));

            if ($request->jenis_zip === 'arab') {
                AudioArab::updateOrCreate(
                    [
                        'ayat_id'    => $ayat->id,
                        'pelantun_id'    => $request->pelantun_id,
                        'langgam_id' => $request->langgam_id,
                    ],
                    [
                        'file_path'  => $pathStorage,
                    ]
                );
            } else {
                AudioGorontalo::updateOrCreate(
                    [
                        'ayat_id'               => $ayat->id,
                        'pembaca_gorontalo_id'  => $request->pembaca_gorontalo_id,
                    ],
                    [
                        'file_path'             => $pathStorage,
                    ]
                );
            }

            $berhasil++;
        }

        File::deleteDirectory($tempDir);

        return back()->with('success', "Berhasil menyimpan {$berhasil} audio!");
    }

    /**
     * 4. Upload eceran (1 ayat) untuk revisi
     */
    public function storeSingle(Request $request, $ayat_id)
    {
        $request->validate([
            'jenis_audio'            => 'required|in:arab,gorontalo',
            'langgam_id'             => 'required_if:jenis_audio,arab|nullable|exists:langgams,id',
            'pelantun_id'                => 'required_if:jenis_audio,arab|nullable|exists:pelantuns,id',
            'pembaca_gorontalo_id'   => 'required_if:jenis_audio,gorontalo|nullable|exists:pelantuns,id',
            // 'file_audio'             => 'required|mimes:mp3|max:10240',
        ], [
            'langgam_id.required_if'           => 'Langgam wajib dipilih untuk audio Arab.',
            'pelantun_id.required_if'              => 'Pelantun wajib dipilih untuk audio Arab.',
            'pembaca_gorontalo_id.required_if' => 'Pembaca Gorontalo wajib dipilih.',
        ]);

        $ayat  = Ayat::findOrFail($ayat_id);
        $surah = Surah::where('no_surah', $ayat->no_surah)->firstOrFail();

        $folderDestinasi = 'audio/ayat/' . $request->jenis_audio;
        $namaFileBaru    = $surah->no_surah . '_' . $ayat->nomorAyat . '_' . time() . '.mp3';

        $pathStorage = $request->file('file_audio')->storeAs(
            $folderDestinasi,
            $namaFileBaru,
            'public'
        );

        if ($request->jenis_audio === 'arab') {
            AudioArab::updateOrCreate(
                [
                    'ayat_id'    => $ayat->id,
                    'pelantun_id'    => $request->pelantun_id,
                    'langgam_id' => $request->langgam_id,
                ],
                [
                    'file_path'  => $pathStorage,
                ]
            );
        } else {
            AudioGorontalo::updateOrCreate(
                [
                    'ayat_id'               => $ayat->id,
                    'pembaca_gorontalo_id'  => $request->pembaca_gorontalo_id,
                ],
                [
                    'file_path'             => $pathStorage,
                ]
            );
        }

        return back()->with('success', 'Audio untuk Ayat ke-' . $ayat->nomorAyat . ' berhasil diperbarui!');
    }

    public function destroyArab($id)
    {
        $audio = AudioArab::findOrFail($id);
        $audio->delete();

        return redirect()->route('editor.usulan.index')->with('success', 'Usulan berhasil dihapus');
    }

        public function destroyGorontalo($id)
    {
        $audio = AudioGorontalo::findOrFail($id);
        $audio->delete();

        return redirect()->route('editor.usulan.index')->with('success', 'Usulan berhasil dihapus');
    }

        public function destroyAllArab(Request $request)
    {
        $audio = AudioArab::where($id);
        $audio->delete();

        return redirect()->route('editor.usulan.index')->with('success', 'Usulan berhasil dihapus');
    }
}