<?php

namespace App\Http\Controllers;

use App\Models\Notebook;
use App\Models\User;
use Illuminate\Http\Request;

class ParticipantsController extends Controller
{
    public function index(Notebook $notebook)
    {
        $participants = $notebook->users;
        return view('notebooks.participants.index', compact('notebook', 'participants'));
    }

    public function remove(Notebook $notebook, User $user)
    {
        $notebook->users()->detach($user->id);
        return back()->with('success', 'User was successfully removed');
    }
}
