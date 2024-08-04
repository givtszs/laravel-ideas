<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;

class AdminIdeasController extends Controller
{
    public function index()
    {
        $ideas = Idea::latest()->paginate(20);
        return view('admin.ideas', compact('ideas'));
    }
}
