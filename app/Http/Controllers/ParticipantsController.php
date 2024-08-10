<?php

namespace App\Http\Controllers;

use App\Models\Notebook;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ParticipantsController extends Controller
{
    public function index(Notebook $notebook)
    {
        $participants = $notebook->users;
        return view('notebooks.participants.index', compact('notebook', 'participants'));
    }

    public function remove(Notebook $notebook, User $participant)
    {
        $notebook->users()->detach($participant->id);
        return back()->with('success', 'User was successfully removed');
    }

    public function makeModerator(Notebook $notebook, User $participant)
    {
        // check if the participant already has any role
        $notebookUser = $notebook->users()->firstWhere('user_id', $participant->id);
        if (!$notebookUser->pivot->role_id) {
            // make moderator
            $roleId = Role::where('name', 'notebook-moderator')->first()?->id;
            if (isset($roleId)) {
                $notebook->users()->updateExistingPivot($participant->id, ['role_id' => $roleId]);
                return back()->with('success', 'Role is granted successfully');
            }
        }

        return back();
    }
}
