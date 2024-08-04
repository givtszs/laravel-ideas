<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }
}
