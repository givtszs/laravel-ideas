<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function profile()
    {
        return $this->show(Auth::user());
    }

    public function show(User $user)
    {
        $topUsers = User::topUsers();
        return view('users.show', compact('user', 'topUsers'));
    }

    public function edit(User $user)
    {
        Gate::authorize('update', $user);
        $editing = true;
        return view('users.show', compact('user', 'editing'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        if ($request->has('profile_picture')) {
            $imagePath = $request->file('profile_picture')->store('profile', 'public');
            $validated['profile_picture'] = $imagePath;
            Storage::disk('public')->delete($user->profile_picture ?? '');
        }
        $user->update($validated);

        $url = Auth::id() === $user->id ? route('profile') : route('users.show', $user->id);

        return redirect($url);
    }

    public function follow(User $user)
    {
        $follower = Auth::user();
        $follower->followings()->attach($user);

        return redirect()->route('users.show', $user->id)->with('success', 'Followed the user successfully');
    }

    public function unfollow(User $user)
    {
        $follower = Auth::user();
        $follower->followings()->detach($user);

        return redirect()->route('users.show', $user->id)->with('success', 'Unllowed the user successfully');
    }
}
