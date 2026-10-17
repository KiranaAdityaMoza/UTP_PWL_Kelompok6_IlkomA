<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KategoriControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_sees_category_add_button_with_form_closed_by_default(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->get(route('kategori.index'));

        $response->assertOk();
        $response->assertSee('Tambah Kategori Kerusakan');
        $response->assertSee('aria-expanded="false"', false);
        $this->assertMatchesRegularExpression(
            '/id="category-form-card"[^>]*\shidden(?:\s|>)/',
            $response->getContent(),
        );
    }

    public function test_admin_can_create_a_damage_category(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->post(route('kategori.store'), [
                'nama_kategori' => 'Peralatan Laboratorium',
                'deskripsi' => 'Kerusakan alat praktikum.',
            ]);

        $response->assertRedirect(route('kategori.index'));
        $this->assertDatabaseHas('kategoris', [
            'nama_kategori' => 'Peralatan Laboratorium',
            'deskripsi' => 'Kerusakan alat praktikum.',
        ]);
    }
}
