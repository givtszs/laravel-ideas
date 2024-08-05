<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    private User $regularUser;
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->regularUser = User::factory()->create();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_guest_user_cant_delete_comment()
    {
        $comment = $this->createComment();

        $response = $this->delete(route('ideas.comments.destroy', [
            'idea' => $comment->idea_id,
            'comment' => $comment->id
        ]));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_user_cant_delete_comment()
    {
        $comment = $this->createComment();

        $response = $this->actingAs($this->regularUser)->delete(route('ideas.comments.destroy', [
            'idea' => $comment->idea_id,
            'comment' => $comment->id
        ]));

        $this->assertAuthenticatedAs($this->regularUser);
        $response->assertStatus(403);
    }

    public function test_admin_can_delete_comment()
    {
        $comment = $this->createComment();

        $response = $this->actingAs($this->admin)->delete(route('ideas.comments.destroy', [
            'idea' => $comment->idea_id,
            'comment' => $comment->id
        ]));

        $this->assertAuthenticatedAs($this->admin);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('comments', $comment->toArray());
    }

    public function test_delete_unexisting_comment()
    {
        $comment = $this->createComment();

        $response = $this->actingAs($this->admin)->delete(route('ideas.comments.destroy', [
            'idea' => $comment->idea_id,
            'comment' => 1000
        ]));

        $this->assertAuthenticatedAs($this->admin);
        $response->assertNotFound();
    }

    private function createComment(): Comment
    {
        $idea = Idea::factory()->create(['user_id' => $this->regularUser->id]);
        return Comment::factory()->create(['user_id' => $idea->user_id, 'idea_id' => $idea->id]);
    }
}
