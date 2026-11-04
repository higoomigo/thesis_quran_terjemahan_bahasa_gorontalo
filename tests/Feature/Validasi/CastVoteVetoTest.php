<?php

namespace Tests\Feature\Validasi;

use App\Models\Ayat;
use App\Models\Surah;
use App\Models\User;
use App\Models\Usulan;
use App\Models\UsulanAssignment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CastVoteVetoTest extends TestCase
{
    use RefreshDatabase;

    public function test_satu_suara_tolak_langsung_menolak_usulan(): void
    {
        Surah::create([
            'no_surah' => 1,
            'nama_latin' => 'Al-Fatihah',
            'nama_arab' => 'الفاتحة',
            'jumlah_ayat' => 7,
            'arti'        => 'Pembukaan',
        ]);

        $ayat = Ayat::create([
            'no_surah' => 1,
            'nomorAyat' => 1,
            'Arab' => 'بِسْمِ اللّٰهِ',
            'teksIndo' => 'Dengan nama Allah',
            'teks_gorontalo' => 'Wonu tanggulo Allah',
            'juz' => 1,
        ]);

        $usulan = Usulan::create([
            'ayat_id' => $ayat->id,
            'nama_pengusul' => 'Pengusul',
            'no_hp' => '08122223333',
            'usulan_teks' => 'Teks usulan untuk uji hak veto.',
            'status' => 'menunggu_validasi',
            'batas_waktu_diskusi' => now()->addDays(14),
        ]);

        $validator = User::factory()->create(['role' => 'teologi']);

        UsulanAssignment::create([
            'usulan_id' => $usulan->id,
            'user_id' => $validator->id,
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($validator)
            ->postJson(route('admin.validasi.chat.vote', $usulan->id), [
                'keputusan' => 'tolak',
            ]);

        if ($response->status() !== 200) {
            dump($response->json());
            dump($response->exception?->getMessage());
        }
        $response->assertOk();

        $usulan->refresh();
        $this->assertEquals('ditolak', $usulan->status);
        $this->assertNotNull($usulan->validated_at);

        $this->assertDatabaseHas('usulan_votes', [
            'usulan_id' => $usulan->id,
            'user_id' => $validator->id,
            'keputusan' => 'tolak',
        ]);
    }
}