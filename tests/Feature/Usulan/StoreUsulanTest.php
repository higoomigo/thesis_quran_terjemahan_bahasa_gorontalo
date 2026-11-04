<?php

namespace Tests\Feature\Usulan;

use App\Models\Ayat;
use App\Models\Surah;
use App\Models\Usulan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreUsulanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Surah::create([
            'no_surah' => 1,
            'nama_latin' => 'Al-Fatihah',
            'nama_arab' => 'الفاتحة',
            'jumlah_ayat' => 7,
            'arti'        => 'Pembukaan',
        ]);

        Ayat::create([
            'no_surah' => 1,
            'nomorAyat' => 1,
            'Arab' => 'بِسْمِ اللّٰهِ',
            'teksIndo' => 'Dengan nama Allah',
            'teks_gorontalo' => 'Wonu tanggulo Allah',
            'juz' => 1,
        ]);
    }

    public function test_usulan_berhasil_disimpan_dengan_data_valid(): void
    {
        $ayat = Ayat::first();

        $response = $this->post(route('usulan.store'), [
            'ayat_id' => $ayat->id,
            'nama_pengusul' => 'Budi Gorontalo',
            'no_hp' => '081234567890',
            'usulan_teks' => 'Usulan perbaikan terjemahan ayat ini agar lebih sesuai dialek setempat.',
        ]);

        $response->assertRedirect();
        // $response->dumpSession();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('usulan_terjemahans', [
            'ayat_id' => $ayat->id,
            'nama_pengusul' => 'Budi Gorontalo',
            'no_hp' => '081234567890',
            'usulan_teks' => 'Usulan perbaikan terjemahan ayat ini agar lebih sesuai dialek setempat.',
        ]);
    }

    public function test_usulan_gagal_jika_data_tidak_lengkap(): void
    {
        $ayat = Ayat::first();

        $response = $this->from(route('usulan.index', [
            'surah_id' => 1,
            'ayat_id' => 1,
        ]))->post(route('usulan.store'), [
            'ayat_id' => $ayat->id,
            'nama_pengusul' => '',
            'no_hp' => '',
            // 'usulan_teks' => 'Usulan perbaikan terjemahan ayat ini agar lebih sesuai dialek setempat.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['nama_pengusul', 'no_hp', 'usulan_teks']);
        $this->assertDatabaseCount('usulan_terjemahans', 0);
    }
}