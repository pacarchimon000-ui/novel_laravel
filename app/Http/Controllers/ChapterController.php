<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\ChapterUnlock;
use App\Models\Novel;
use App\Models\ReadingHistory;
use App\Models\ReadingReward;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChapterController extends Controller
{
    public function show(Novel $novel, Chapter $chapter)
    {
        if ($chapter->novel_id !== $novel->id || $novel->approval_status !== 'approved') {
            abort(404);
        }

        $hasAccess = $this->hasChapterAccess($chapter);

        $chapter->load(['novel', 'comments.user']);

        if ($hasAccess) {
            $novel->increment('views');
            $chapter->increment('views');
        }

        $prevChapter = $chapter->previousChapter();
        $nextChapter = $chapter->nextChapter();

        $locked = ! $hasAccess;
        $reward = null;

        return view('chapters.show', compact('novel', 'chapter', 'prevChapter', 'nextChapter', 'locked', 'reward'));
    }

    public function complete(Request $request, Novel $novel, Chapter $chapter)
    {
        if ($chapter->novel_id !== $novel->id || $novel->approval_status !== 'approved') {
            abort(404);
        }

        $this->ensureChapterAccess($chapter);

        $reward = $this->recordReadingReward($novel, $chapter);

        return back()->with('reading_reward', [
            'points' => $reward->wasRecentlyCreated ? $reward->points : 0,
            'coins' => $reward->wasRecentlyCreated ? $reward->coins : 0,
        ]);
    }

    private function recordReadingReward(Novel $novel, Chapter $chapter): ?ReadingReward
    {
        return DB::transaction(function () use ($novel, $chapter): ?ReadingReward {
            $user = auth()->user()->newQuery()->lockForUpdate()->findOrFail(auth()->id());

            ReadingHistory::updateOrCreate(
                ['user_id' => $user->id, 'novel_id' => $novel->id],
                ['chapter_id' => $chapter->id]
            );

            $reward = ReadingReward::firstOrCreate(
                ['user_id' => $user->id, 'chapter_id' => $chapter->id],
                ['points' => 5, 'coins' => 0]
            );

            if (! $reward->wasRecentlyCreated) {
                return $reward;
            }

            $oldMilestone = intdiv((int) $user->reading_points, 100);
            $newPoints = $user->reading_points + $reward->points;
            $newMilestone = intdiv($newPoints, 100);
            $coins = 0;

            if ($newMilestone > $oldMilestone) {
                $coins = ($newMilestone - $oldMilestone) * 2; // 2 coins per 100-point milestone
                $reward->update(['coins' => $coins]);
                $user->increment('coins', $coins);
            }

            $user->update(['reading_points' => $newPoints, 'reading_level' => $newMilestone + 1]);

            return $reward;
        });
    }

    public function downloadPdf(Novel $novel, Chapter $chapter)
    {
        if ($chapter->novel_id !== $novel->id || $novel->approval_status !== 'approved') {
            abort(404);
        }

        $this->ensureChapterAccess($chapter);

        $pdf = Pdf::loadView('pdf.chapter', compact('novel', 'chapter'));
        $filename = Str::of($novel->title . '-chapter-' . $chapter->chapter_number)->slug() . '.pdf';
        return $pdf->download($filename);
    }

    public function unlock(Request $request, Novel $novel, Chapter $chapter)
    {
        if ($chapter->novel_id !== $novel->id || $novel->approval_status !== 'approved') {
            abort(404);
        }

        if (! $chapter->is_premium || $this->hasChapterAccess($chapter)) {
            return back()->with('success', 'Chapter sudah dapat diakses.');
        }

        DB::transaction(function () use ($chapter) {
            $user = $this->userForUnlock();
            $user = $user->newQuery()->lockForUpdate()->findOrFail($user->id);
            $lockedChapter = Chapter::query()->lockForUpdate()->findOrFail($chapter->id);

            if (ChapterUnlock::where('user_id', $user->id)->where('chapter_id', $lockedChapter->id)->exists()) {
                return;
            }

            if ($user->coins < $lockedChapter->coin_price) {
                abort(403, 'Saldo coin tidak mencukupi.');
            }

            $user->decrement('coins', $lockedChapter->coin_price);
            ChapterUnlock::create([
                'user_id' => $user->id,
                'chapter_id' => $lockedChapter->id,
            ]);
        });

        return back()->with('success', 'Chapter berhasil dibuka.');
    }

    private function ensureChapterAccess(Chapter $chapter): void
    {
        abort_unless($this->hasChapterAccess($chapter), 403);
    }

    private function hasChapterAccess(Chapter $chapter): bool
    {
        if (! $chapter->is_premium) {
            return true;
        }

        if (! auth()->check()) {
            return false;
        }

        return auth()->user()->isAdmin()
            || $chapter->novel->user_id === auth()->id()
            || ChapterUnlock::where('user_id', auth()->id())->where('chapter_id', $chapter->id)->exists();
    }

    private function userForUnlock()
    {
        abort_unless(auth()->check(), 401);

        return auth()->user();
    }
}
