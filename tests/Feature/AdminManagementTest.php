<?php

namespace Tests\Feature;

use App\Models\Report;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Novel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_filter_users_by_search_role_and_writer_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create([
            'name' => 'Writer Dicari',
            'email' => 'writer@example.com',
            'role' => 'writer',
            'writer_status' => 'approved',
        ]);
        User::factory()->create(['name' => 'User Lain', 'email' => 'other@example.com']);

        $this->actingAs($admin)
            ->get(route('admin.users.index', [
                'search' => 'writer@example.com',
                'role' => 'writer',
                'writer_status' => 'approved',
            ]))
            ->assertOk()
            ->assertSee('Writer Dicari')
            ->assertDontSee('User Lain');
    }

    public function test_admin_can_filter_reports_by_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $novel = Novel::create([
            'user_id' => $admin->id,
            'title' => 'Report Novel',
            'slug' => 'report-novel',
            'synopsis' => 'Synopsis',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
            'approval_status' => 'approved',
        ]);
        $chapter = Chapter::create([
            'novel_id' => $novel->id,
            'chapter_number' => 1,
            'title' => 'Chapter 1',
            'content' => 'Content',
        ]);
        $comment = Comment::create([
            'user_id' => $user->id,
            'chapter_id' => $chapter->id,
            'content' => 'Komentar yang dilaporkan',
        ]);

        Report::create([
            'user_id' => $user->id,
            'comment_id' => $comment->id,
            'reason' => 'Spam',
            'status' => 'pending',
        ]);
        Report::create([
            'user_id' => $user->id,
            'comment_id' => $comment->id,
            'reason' => 'Sudah selesai',
            'status' => 'resolved',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.reports.index', ['status' => 'pending']))
            ->assertOk()
            ->assertSee('Spam')
            ->assertDontSee('Sudah selesai');
    }
}