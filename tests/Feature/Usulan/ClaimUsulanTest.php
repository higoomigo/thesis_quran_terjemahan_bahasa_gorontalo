<?php

namespace Tests\Feature\Usulan;

use App\Models\Ayat;
use App\Models\Surah;
use App\Models\User;
use App\Models\Usulan;
use App\Models\UsulanAssignment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClaimUsulanTest extends TestCase
{
    use RefreshDatabase;

    protected Usulan $usulan;

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

        $ayat = Ayat::create([
            'no_surah' => 1,
            'nomorAyat' => 1,
            'Arab' => 'بِسْمِ اللّٰهِ',
            'teksIndo' => 'Dengan nama Allah',
            'teks_gorontalo' => 'Wonu tanggulo Allah',
            'juz' => 1,
        ]);

        $this->usulan = Usulan::create([
            'ayat_id' => $ayat->id,
            'nama_pengusul' => 'Pengusul A',
            'no_hp' => '081111111111',
            'usulan_teks' => 'Perbaikan diksi terjemahan Gorontalo.',
            'status' => 'menunggu_validasi',
        ]);
    }

    public function test_validator_bisa_klaim_usulan(): void
    {
        $validator = User::factory()->create(['role' => 'teologi']);

        $response = $this->actingAs($validator)
            ->postJson(route('admin.usulan.claim', $this->usulan->id));

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('usulan_assignments', [
            'usulan_id' => $this->usulan->id,
            'user_id' => $validator->id,
            'status' => 'aktif',
        ]);
    }

    public function test_validator_tidak_bisa_klaim_dua_kali(): void
    {
        $validator = User::factory()->create(['role' => 'teologi']);

        UsulanAssignment::create([
            'usulan_id' => $this->usulan->id,
            'user_id' => $validator->id,
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($validator)
            ->postJson(route('admin.usulan.claim', $this->usulan->id));

        $response->assertStatus(400);
        $this->assertEquals(
            1,
            UsulanAssignment::where('usulan_id', $this->usulan->id)->count()
        );
    }

    public function test_kuota_teologi_maksimal_dua(): void
    {
        $v1 = User::factory()->create(['role' => 'teologi']);
        $v2 = User::factory()->create(['role' => 'teologi']);
        $v3 = User::factory()->create(['role' => 'teologi']);

        UsulanAssignment::create([
            'usulan_id' => $this->usulan->id,
            'user_id' => $v1->id,
            'status' => 'aktif',
        ]);
        UsulanAssignment::create([
            'usulan_id' => $this->usulan->id,
            'user_id' => $v2->id,
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($v3)
            ->postJson(route('admin.usulan.claim', $this->usulan->id));

        $response->assertStatus(400);
        $this->assertDatabaseMissing('usulan_assignments', [
            'usulan_id' => $this->usulan->id,
            'user_id' => $v3->id,
        ]);
    }
}