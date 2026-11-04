<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_tidak_bisa_akses_area_admin(): void
    {
        $response = $this->get('/admin/usulan');

        // sesuaikan: assertRedirect('/login') atau assertForbidden()
        $response->assertRedirect();
    }

    public function test_publik_tidak_bisa_akses_area_admin(): void
    {
        $publik = User::factory()->create(['role' => null]);

        $response = $this->actingAs($publik)->get('/admin/usulan');

        // sesuaikan dengan middleware kamu
        $this->assertTrue(
            in_array($response->status(), [302, 403, 401])
        );
    }

    public function test_validator_bisa_akses_daftar_usulan(): void
    {
        $validator = User::factory()->create(['role' => 'teologi']);

        $response = $this->actingAs($validator)
            ->get(route('admin.usulan.index'));

        $response->assertOk();
    }
}