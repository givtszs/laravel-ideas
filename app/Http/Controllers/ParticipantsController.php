<?php

namespace App\Http\Controllers;

use App\Models\Notebook;
use Illuminate\Http\Request;

class ParticipantsController extends Controller
{
    public function index(Notebook $notebook)
    {
        $participants = $notebook->users;
        return view('notebooks.participants.index', compact('notebook', 'participants'));
    }
}
