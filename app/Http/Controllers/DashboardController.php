<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $ideas = Idea::orderBy('created_at', 'DESC');

        $topUsers = User::topUsers();

        if (request()->has('search')) {
            $ideas = $ideas->search(request('search'));
        }

        return view('dashboard', [
            'ideas' => $ideas->paginate(20),
            'topUsers' => $topUsers
        ]);
    }
}
