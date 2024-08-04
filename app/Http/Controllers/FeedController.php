<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $followings = Auth::user()->followings()->pluck('user_id');
        $ideas = Idea::whereIn('user_id', $followings)->latest();

        if (request()->has('search')) {
            $ideas = $ideas->search($request->get('search'));
        }

        return view('feed', ['ideas' => $ideas->paginate(20)]);
    }
}
