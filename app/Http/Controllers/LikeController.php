<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Novel $novel)
    {
        $user = auth()->user();
        $like = Like::where('user_id', $user->id)->where('novel_id', $novel->id)->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create(['user_id' => $user->id, 'novel_id' => $novel->id]);
        }

        return back();
    }
}
