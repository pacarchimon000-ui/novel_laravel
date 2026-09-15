<?php

namespace Tests\Feature;

use App\Models\Chapter;
use App\Models\Novel;
use App\Models\User;
use App\Notifications\NewChapterNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NovelFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_chapter_belongs_to_the_requested_novel(): void
    {
        $user = User::factory()->create();
        $novelA = Novel::create([
            'user_id' => $user->id,
            'title' => 'Novel A',
            'slug' => 'novel-a',
            'synopsis' => 'Synopsis A',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
        ]);
        $novelB = Novel::create([
            'user_id' => $user->id,
            'title' => 'Novel B',
            'slug' => 'novel-b',
            'synopsis' => 'Synopsis B',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
        ]);

        $chapterB = Chapter::create([
            'novel_id' => $novelB->id,
            'chapter_number' => 1,
            'title' => 'Chapter 1',
            'content' => 'Hello world',
        ]);

        $response = $this->get(route('chapters.show', ['novel' => $novelA, 'chapter' => $chapterB]));

        $response->assertNotFound();
    }

    public function test_novel_search_matches_author_name(): void
    {
        $author = User::factory()->create(['name' => 'Penulis Fantasi']);
        $otherAuthor = User::factory()->create(['name' => 'Penulis Lain']);

        Novel::create([
            'user_id' => $author->id,
            'title' => 'Cerita Biasa',
            'slug' => 'cerita-biasa',
            'synopsis' => 'Kisah pertama',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
            'approval_status' => 'approved',
        ]);
        Novel::create([
            'user_id' => $otherAuthor->id,
            'title' => 'Cerita Lain',
            'slug' => 'cerita-lain',
            'synopsis' => 'Kisah kedua',
            'genre' => 'Romance',
            'status' => 'ongoing',
            'approval_status' => 'approved',
        ]);

        $this->get(route('novels.index', ['search' => 'Penulis Fantasi', 'sort' => 'likes']))
            ->assertOk()
            ->assertSee('Cerita Biasa')
            ->assertDontSee('Cerita Lain');
    }

    public function test_duplicate_chapter_number_for_same_novel_is_rejected(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $novel = Novel::create([
            'user_id' => $admin->id,
            'title' => 'Test Novel',
            'slug' => 'test-novel',
            'synopsis' => 'Test synopsis',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
        ]);

        Chapter::create([
            'novel_id' => $novel->id,
            'chapter_number' => 1,
            'title' => 'First chapter',
            'content' => 'It is alive',
        ]);

        $this->actingAs($admin)
            ->from(route('admin.novels.show', $novel))
            ->post(route('admin.chapters.store', $novel), [
                'chapter_number' => 1,
                'title' => 'Duplicate chapter',
                'content' => 'Should fail',
            ])
            ->assertSessionHasErrors('chapter_number');
    }

    public function test_notification_redirect_uses_chapter_id_for_navigation(): void
    {
        $user = User::factory()->create();
        $novel = Novel::create([
            'user_id' => $user->id,
            'title' => 'Notification Novel',
            'slug' => 'notification-novel',
            'synopsis' => 'Synopsis',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
        ]);
        $chapter = Chapter::create([
            'novel_id' => $novel->id,
            'chapter_number' => 2,
            'title' => 'Second chapter',
            'content' => 'More content',
        ]);

        $user->notify(new NewChapterNotification($novel, $chapter));
        $notification = $user->notifications()->first();

        $response = $this->actingAs($user)->post(route('notifications.read', $notification->id));

        $response->assertRedirect(route('chapters.show', ['novel' => $novel, 'chapter' => $chapter->id]));
    }

    public function test_pdf_export_route_returns_pdf_response(): void
    {
        $user = User::factory()->create();
        $novel = Novel::create([
            'user_id' => $user->id,
            'title' => 'Pdf Novel',
            'slug' => 'pdf-novel',
            'synopsis' => 'Synopsis',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
        ]);
        $chapter = Chapter::create([
            'novel_id' => $novel->id,
            'chapter_number' => 3,
            'title' => 'Third chapter',
            'content' => 'Content for pdf',
        ]);

        $response = $this->get(route('chapters.pdf', ['novel' => $novel, 'chapter' => $chapter]));

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_opening_a_chapter_increments_the_related_novel_view_count(): void
    {
        $user = User::factory()->create();
        $novel = Novel::create([
            'user_id' => $user->id,
            'title' => 'Viewed Novel',
            'slug' => 'viewed-novel',
            'synopsis' => 'Synopsis',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
            'views' => 0,
        ]);
        $chapter = Chapter::create([
            'novel_id' => $novel->id,
            'chapter_number' => 1,
            'title' => 'Chapter 1',
            'content' => 'Content',
        ]);

        $this->assertSame(0, $novel->fresh()->views);

        $this->get(route('chapters.show', ['novel' => $novel, 'chapter' => $chapter]));

        $this->assertSame(1, $novel->fresh()->views);
    }

    public function test_premium_chapter_requires_unlock(): void
    {
        $author = User::factory()->create(['role' => 'writer']);
        $user = User::factory()->create(['coins' => 20]);
        $novel = Novel::create([
            'user_id' => $author->id,
            'title' => 'Premium Novel',
            'slug' => 'premium-novel',
            'synopsis' => 'Synopsis',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
        ]);
        $chapter = Chapter::create([
            'novel_id' => $novel->id,
            'chapter_number' => 1,
            'title' => 'Premium chapter',
            'content' => 'Premium content',
            'is_premium' => true,
            'coin_price' => 10,
        ]);

        $this->actingAs($user)
            ->get(route('chapters.show', [$novel, $chapter]))
            ->assertOk()
            ->assertSee('Chapter Premium')
            ->assertDontSee('Premium content');

        $this->actingAs($user)
            ->post(route('chapters.unlock', [$novel, $chapter]))
            ->assertRedirect();

        $this->assertSame(10, $user->fresh()->coins);
        $this->assertDatabaseHas('chapter_unlocks', [
            'user_id' => $user->id,
            'chapter_id' => $chapter->id,
        ]);

        $this->actingAs($user)
            ->get(route('chapters.show', [$novel, $chapter]))
            ->assertOk();
    }

    public function test_premium_chapter_cannot_be_unlocked_without_enough_coins(): void
    {
        $author = User::factory()->create(['role' => 'writer']);
        $user = User::factory()->create(['coins' => 5]);
        $novel = Novel::create([
            'user_id' => $author->id,
            'title' => 'Expensive Novel',
            'slug' => 'expensive-novel',
            'synopsis' => 'Synopsis',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
        ]);
        $chapter = Chapter::create([
            'novel_id' => $novel->id,
            'chapter_number' => 1,
            'title' => 'Expensive chapter',
            'content' => 'Premium content',
            'is_premium' => true,
            'coin_price' => 10,
        ]);

        $this->actingAs($user)
            ->post(route('chapters.unlock', [$novel, $chapter]))
            ->assertForbidden();

        $this->assertSame(5, $user->fresh()->coins);
        $this->assertDatabaseMissing('chapter_unlocks', [
            'user_id' => $user->id,
            'chapter_id' => $chapter->id,
        ]);
    }

    public function test_admin_cannot_edit_a_chapter_through_the_wrong_novel(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $novelA = Novel::create([
            'user_id' => $admin->id,
            'title' => 'Novel A',
            'slug' => 'admin-novel-a',
            'synopsis' => 'Synopsis',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
        ]);
        $novelB = Novel::create([
            'user_id' => $admin->id,
            'title' => 'Novel B',
            'slug' => 'admin-novel-b',
            'synopsis' => 'Synopsis',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
        ]);
        $chapter = Chapter::create([
            'novel_id' => $novelB->id,
            'chapter_number' => 1,
            'title' => 'Chapter',
            'content' => 'Content',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.chapters.update', [$novelA, $chapter]), [
                'chapter_number' => 2,
                'title' => 'Should not update',
                'content' => 'Should not update',
            ])
            ->assertNotFound();

        $this->assertSame(1, $chapter->fresh()->chapter_number);
    }
}
