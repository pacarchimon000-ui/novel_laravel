<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show(User $user)
    {
        $user->loadCount(['novels', 'followers', 'following']);

        $novels = $user->novels()
            ->public()
            ->withCount(['chapters', 'likes', 'bookmarks'])
            ->latest()
            ->paginate(12);

        $isFollowing = auth()->check() ? $user->isFollowedBy(auth()->user()) : false;

        return view('authors.show', compact('user', 'novels', 'isFollowing'));
    }
}
