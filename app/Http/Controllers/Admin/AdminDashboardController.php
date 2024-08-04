<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::all()->count();
        $totalIdeas = Idea::all()->count();
        $totalComments = Comment::all()->count();
        return view(
            'admin.dashboard',
            compact('totalUsers', 'totalIdeas', 'totalComments')
        );
    }
}
