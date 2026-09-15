<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CoinController extends Controller
{
    public function index(Request $request): View
    {
        return view('coins.index', [
            'rewards' => $request->user()->readingRewards()->with('chapter.novel')->latest()->paginate(10),
        ]);
    }
}