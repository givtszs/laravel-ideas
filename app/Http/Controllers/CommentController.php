<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Idea $idea)
    {
        $validated = $request->validated();
        Comment::create([
            'idea_id' => $idea->id,
            'user_id' => Auth::id(),
            'content' => $validated['content']
        ]);

        return redirect()->route('ideas.show', $idea->id)->with('success', 'Comment is written successfully');
    }

    public function destroy(Idea $idea, Comment $comment)
    {
        $comment->delete();
        return back();
    }
}
