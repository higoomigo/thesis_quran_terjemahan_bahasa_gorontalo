<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class KemenagFootnoteSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('../../kemenag_footnotes.json');

        if (!File::exists($path)) {
            $this->command->error("File tidak ditemukan di: {$path}");
            return;
        }

        // SESUAIKAN dengan nama kolom terjemahan Indonesia di tabel `ayats` lu!
        $kolomTerjemahanIndo = 'teksIndo';

        $data = json_decode(File::get($path), true);

        // Mapping semua ayat sekali query biar nggak lemot: "no_surah:nomorAyat" => id
        $ayatMap = DB::table('ayats')
            ->select('id', 'no_surah', 'nomorAyat')
            ->get()
            ->mapWithKeys(fn ($row) => ["{$row->no_surah}:{$row->nomorAyat}" => $row->id]);

        $now = now();
        $footnotesBatch = [];
        $updatedCount = 0;

        DB::transaction(function () use (
            $data,
            $ayatMap,
            $kolomTerjemahanIndo,
            $now,
            &$footnotesBatch,
            &$updatedCount
        ) {
            // Hapus footnote Indonesia lama biar aman kalau seeder dijalankan ulang
            DB::table('footnotes')->where('bahasa', 'indonesia')->delete();

            foreach ($data as $noSurah => $ayats) {
                foreach ($ayats as $item) {
                    $key = "{$noSurah}:{$item['no_ayat']}";
                    $ayatId = $ayatMap[$key] ?? null;

                    if (!$ayatId) {
                        continue;
                    }

                    // 1. Update terjemahan Indonesia dengan versi ber-penanda [1]
                    DB::table('ayats')
                        ->where('id', $ayatId)
                        ->update([
                            $kolomTerjemahanIndo => $item['terjemahan'],
                        ]);

                    $updatedCount++;

                    // 2. Kumpulkan catatan kaki untuk batch insert
                    if (!empty($item['footnotes'])) {
                        foreach ($item['footnotes'] as $fn) {
                            $footnotesBatch[] = [
                                'ayat_id'    => $ayatId,
                                'nomor'      => $fn['nomor'],
                                'bahasa'     => 'indonesia',
                                'isi'        => $fn['isi'],
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }
                    }
                }
            }

            // Insert bertahap per 500 baris biar MySQL nggak keberatan
            foreach (array_chunk($footnotesBatch, 500) as $chunk) {
                DB::table('footnotes')->insertOrIgnore($chunk);
            }
        });

        $this->command->info("Berhasil update {$updatedCount} ayat dan memasukkan " . count($footnotesBatch) . " catatan kaki!");
    }
}