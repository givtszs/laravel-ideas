<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Stringable;

class IdeaController extends Controller
{
    public function store(StoreIdeaRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        Idea::create($validated);

        return redirect()->route('dashboard')->with('success', 'Idea is created successfully');
    }

    public function destroy(Idea $idea)
    {
        Gate::authorize('delete', $idea);
        $idea->delete();

        $targetUrl = back()->getTargetUrl();
        if (Str::contains($targetUrl, 'ideas')) {
            $targetUrl = Str::contains($targetUrl, 'admin') ? route('admin.ideas') : route('dashboard');
        }

        return redirect($targetUrl)->with('success', 'Idea is deleted successfully');
    }

    public function show(Idea $idea)
    {
        return view('ideas.show', ['idea' => $idea]);
    }

    public function edit(Idea $idea)
    {
        Gate::authorize('update', $idea);
        return view('ideas.show', ['idea' => $idea, 'editing' => true]);
    }

    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        $idea->update($request->validated());
        return redirect()->route('ideas.show', $idea->id)->with('success', 'Idea is updated successfully');
    }

    public function like(Idea $idea)
    {
        if (Auth::user()->doesLikeIdea($idea)) {
            $idea->likes()->detach(Auth::user());
            $message = 'Idea is unliked';
        } else {
            $idea->likes()->attach(Auth::user());
            $message = 'Idea is liked';
        }
        return redirect()->route('dashboard')->with('success', $message);
    }
}
