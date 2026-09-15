<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, Novel $novel)
    {
        $request->validate([
            'stars'  => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        Rating::updateOrCreate(
            [
                'user_id'  => auth()->id(),
                'novel_id' => $novel->id,
            ],
            [
                'stars'  => $request->stars,
                'review' => $request->review,
            ]
        );

        return back()->with('success', 'Terima kasih atas ulasan dan rating kamu!');
    }
}
