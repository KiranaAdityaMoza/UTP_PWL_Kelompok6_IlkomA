<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PengaduanMahasiswaTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_can_open_pengaduan_form_and_submit_report(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'mahasiswa',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => 'Fasilitas Kelas',
            'deskripsi' => 'Kerusakan pada fasilitas kelas',
        ]);

        $response = $this->actingAs($user)
            ->get('/pengaduan/create');

        $response->assertOk();
        $response->assertSee('Pilih kategori kerusakan');
        $response->assertSee('Fasilitas Kelas');

        $file = UploadedFile::fake()->image('kerusakan.jpg', 640, 480);

        $submit = $this->actingAs($user)
            ->post('/pengaduan', [
                'kategori_id' => $kategori->id,
                'judul_laporan' => 'AC mati di ruang 101',
                'lokasi' => 'Ruang 101',
                'deskripsi' => 'AC tidak dingin sejak pagi.',
                'foto' => $file,
            ]);

        $submit->assertRedirect(route('pengaduan.index', absolute: false));
        $this->assertDatabaseHas('pengaduans', [
            'user_id' => $user->id,
            'kategori_id' => $kategori->id,
            'judul_laporan' => 'AC mati di ruang 101',
            'status' => 'Pending',
        ]);
        $this->assertDatabaseCount('pengaduans', 1);
    }

    public function test_mahasiswa_cannot_access_other_students_report_detail(): void
    {
        $owner = User::factory()->create(['role' => 'mahasiswa']);
        $other = User::factory()->create(['role' => 'mahasiswa']);
        $kategori = Kategori::create([
            'nama_kategori' => 'Toilet',
            'deskripsi' => 'Kebersihan',
        ]);

        $report = Pengaduan::create([
            'user_id' => $owner->id,
            'kategori_id' => $kategori->id,
            'judul_laporan' => 'Toilet rusak',
            'lokasi' => 'Gedung A',
            'deskripsi' => 'Kran bocor',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($other)
            ->get('/pengaduan/'.$report->id);

        $response->assertNotFound();
    }

    public function test_admin_dashboard_does_not_show_category_management_card(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
        ]);

        $response = $this->actingAs($admin)
            ->get('/dashboard');

        $response->assertOk();
        $this->assertSame(
            1,
            substr_count($response->getContent(), route('kategori.index', absolute: false)),
        );
    }
}
