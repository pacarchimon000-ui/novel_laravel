<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ReadingReward;

class CoinController extends Controller
{
    /**
     * Tampilkan halaman coin & EXP reward
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $rewards = $user->readingRewards()
            ->with('chapter.novel')
            ->latest()
            ->paginate(15);

        $points = (int) $user->reading_points;
        $levelProgress = $points % 100;
        $pointsToNextMilestone = 100 - $levelProgress;
        $totalMilestones = intdiv($points, 100);

        return view('coins.index', [
            'user' => $user,
            'rewards' => $rewards,
            'levelProgress' => $levelProgress,
            'pointsToNextMilestone' => $pointsToNextMilestone,
            'totalMilestones' => $totalMilestones,
        ]);
    }
}
