<?php

namespace Tests\Feature;

use App\Models\Novel;
use App\Models\User;
use App\Notifications\WriterRequestNotification;
use App\Notifications\WriterStatusNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class WriterAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_approved_writer_can_access_writer_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'writer',
            'writer_status' => 'approved',
        ]);

        $this->actingAs($user)
            ->get('/writer/dashboard')
            ->assertOk();
    }

    public function test_pending_writer_cannot_access_writer_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'writer_status' => 'pending',
        ]);

        $this->actingAs($user)
            ->get('/writer/dashboard')
            ->assertStatus(403);
    }

    public function test_admin_can_approve_writer_request(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'writer_status' => 'approved',
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'writer_status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->post("/admin/users/{$user->id}/approve-writer")
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'writer',
            'writer_status' => 'approved',
        ]);
    }

    public function test_admin_dashboard_shows_pending_writer_request(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'writer_status' => 'approved',
        ]);

        $user = User::factory()->create([
            'name' => 'Calon Writer',
            'role' => 'user',
            'writer_status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Calon Writer')
            ->assertSee('Pengajuan Writer')
            ->assertSee((string) $user->email)
            ->assertSee('Pengajuan Writer')
            ->assertSee('Belum diisi');
    }

    public function test_admin_dashboard_shows_writer_application_details(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create([
            'name' => 'Detail Writer',
            'role' => 'user',
            'writer_status' => 'pending',
            'writer_application_email' => 'detail@example.com',
            'writer_application_motivation' => 'Saya ingin menulis cerita edukatif untuk pembaca.',
            'writer_application_experience' => 'Pernah menulis beberapa cerita pendek.',
            'writer_application_genre' => 'Edukasi',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Detail Writer')
            ->assertSee('Edukasi')
            ->assertSee('Saya ingin menulis cerita edukatif untuk pembaca.');
    }

    public function test_admin_pending_writer_page_shows_full_application_details(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create([
            'name' => 'Pending Detail Writer',
            'role' => 'user',
            'writer_status' => 'pending',
            'writer_application_email' => 'pending@example.com',
            'writer_application_motivation' => 'Saya ingin menulis cerita untuk pembaca.',
            'writer_application_experience' => 'Pernah menulis artikel dan cerita pendek.',
            'writer_application_genre' => 'Romance',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.users.pending-writers'))
            ->assertOk()
            ->assertSee('Pending Detail Writer')
            ->assertSee('pending@example.com')
            ->assertSee('Pernah menulis artikel dan cerita pendek.')
            ->assertSee('Romance');
    }

    public function test_writer_can_see_only_own_novels(): void
    {
        $writer = User::factory()->create([
            'role' => 'writer',
            'writer_status' => 'approved',
        ]);
        $otherWriter = User::factory()->create([
            'role' => 'writer',
            'writer_status' => 'approved',
        ]);

        Novel::factory()->create([
            'user_id' => $writer->id,
            'title' => 'Novel Saya',
        ]);

        Novel::factory()->create([
            'user_id' => $otherWriter->id,
            'title' => 'Novel Orang Lain',
        ]);

        $response = $this->actingAs($writer)->get('/writer/novels');

        $response->assertOk();
        $response->assertSee('Novel Saya');
        $response->assertDontSee('Novel Orang Lain');
    }

    public function test_user_can_request_to_become_writer_from_profile(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'writer_status' => 'not_requested',
        ]);

        $this->actingAs($user)
            ->post('/profile/request-writer', [
                'writer_application_email' => 'writer@example.com',
                'writer_application_motivation' => 'Saya ingin berbagi cerita yang bermanfaat.',
                'writer_application_experience' => 'Saya pernah menulis cerita pendek.',
                'writer_application_genre' => 'Fantasi',
                'writer_application_agreement' => '1',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'user',
            'writer_status' => 'pending',
            'writer_application_email' => 'writer@example.com',
            'writer_application_genre' => 'Fantasi',
        ]);
    }

    public function test_user_request_notifies_admins(): void
    {
        Notification::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
            'writer_status' => 'approved',
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'writer_status' => 'not_requested',
        ]);

        $this->actingAs($user)
            ->post('/profile/request-writer', [
                'writer_application_email' => 'writer@example.com',
                'writer_application_motivation' => 'Saya ingin berbagi cerita yang bermanfaat.',
                'writer_application_experience' => 'Saya pernah menulis cerita pendek.',
                'writer_application_genre' => 'Fantasi',
                'writer_application_agreement' => '1',
            ]);

        Notification::assertSentTo($admin, WriterRequestNotification::class);
    }

    public function test_admin_approval_notifies_user(): void
    {
        Notification::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
            'writer_status' => 'approved',
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'writer_status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->post("/admin/users/{$user->id}/approve-writer");

        Notification::assertSentTo($user, WriterStatusNotification::class);
    }
}
