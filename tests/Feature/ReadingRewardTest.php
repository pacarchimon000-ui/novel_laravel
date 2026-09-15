<?php

namespace Tests\Feature;

use App\Models\Chapter;
use App\Models\Novel;
use App\Models\ReadingReward;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadingRewardTest extends TestCase
{
    use RefreshDatabase;

    public function test_opening_a_chapter_does_not_reward_until_it_is_completed(): void
    {
        $user = User::factory()->create(['coins' => 0]);
        $novel = Novel::create([
            'user_id' => User::factory()->create(['role' => 'writer'])->id,
            'title' => 'Reward Novel',
            'slug' => 'reward-novel',
            'synopsis' => 'Synopsis',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
            'approval_status' => 'approved',
        ]);
        $chapter = Chapter::create([
            'novel_id' => $novel->id,
            'chapter_number' => 1,
            'title' => 'First chapter',
            'content' => 'Content',
        ]);

        $this->actingAs($user)->get(route('chapters.show', [$novel, $chapter]))->assertOk();
        $this->assertSame(0, $user->fresh()->reading_points);

        $this->actingAs($user)->post(route('chapters.complete', [$novel, $chapter]))->assertRedirect();
        $this->actingAs($user)->post(route('chapters.complete', [$novel, $chapter]))->assertRedirect();

        $this->assertSame(10, $user->fresh()->reading_points);
        $this->assertSame(0, $user->fresh()->coins);
        $this->assertSame(1, ReadingReward::where('user_id', $user->id)->count());
    }

    public function test_every_hundred_reading_points_awards_alternating_coins(): void
    {
        $user = User::factory()->create(['coins' => 0]);
        $writer = User::factory()->create(['role' => 'writer']);
        $novel = Novel::create([
            'user_id' => $writer->id,
            'title' => 'Milestone Novel',
            'slug' => 'milestone-novel',
            'synopsis' => 'Synopsis',
            'genre' => 'Fantasy',
            'status' => 'ongoing',
            'approval_status' => 'approved',
        ]);

        foreach (range(1, 20) as $number) {
            $chapter = Chapter::create([
                'novel_id' => $novel->id,
                'chapter_number' => $number,
                'title' => "Chapter {$number}",
                'content' => 'Content',
            ]);

            $this->actingAs($user)->get(route('chapters.show', [$novel, $chapter]));
            $this->actingAs($user)->post(route('chapters.complete', [$novel, $chapter]));
        }

        $freshUser = $user->fresh();
        $this->assertSame(200, $freshUser->reading_points);
        $this->assertSame(3, $freshUser->coins);
        $this->assertSame(3, $freshUser->reading_level);
    }
}