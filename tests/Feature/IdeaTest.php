<?php

namespace Tests\Feature;

use App\Enums\RolesEnum;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class IdeaTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;
    private User $user;
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->user = $this->createUser();
        $this->admin = $this->createUser(isAdmin: true);
    }

    public function test_guest_user_cant_store_ideas()
    {
        $response = $this->post(route('ideas.store'));

        $response->assertStatus(302);
        $this->assertGuest();
    }

    public function test_authenticated_user_can_store_ideas()
    {
        $ideaContent = 'Test';

        $response = $this->actingAs($this->user)->post(
            route('ideas.store'),
            ['content' => $ideaContent]
        );

        $this->assertAuthenticated();
        $response->assertStatus(302);
        $this->assertDatabaseHas('ideas', [
            'content' => $ideaContent,
            'user_id' => $this->user->id
        ]);

        $lastIdea = Idea::latest()->first();
        $this->assertEquals($ideaContent, $lastIdea->content);
        $this->assertEquals($this->user->id, $lastIdea->user_id);
    }

    public function test_cant_store_idea_with_empty_content()
    {
        $response = $this->actingAs($this->user)->post(route('ideas.store'));

        $this->assertAuthenticated();
        $response->assertSessionHasErrors('content');
    }

    public function test_edit_idea_page_contains_correct_values()
    {
        $idea = $this->createIdea();

        $response = $this->actingAs($this->user)->get(route('ideas.edit', $idea->id));

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertSee($idea->content);
        $response->assertViewHas('idea', $idea);
    }

    public function test_admin_can_access_edit_idea_page()
    {
        $idea = $this->createIdea();

        $response = $this->actingAs($this->admin)->get(route('ideas.edit', $idea->id));

        $this->assertAuthenticated();
        $response->assertStatus(200);
    }

    public function test_unauthorized_user_cant_access_edit_idea_page()
    {
        $idea = $this->createIdea();
        $unauthorizedUser = $this->createUser();

        $response = $this->actingAs($unauthorizedUser)->get(route('ideas.edit', $idea->id));

        $this->assertAuthenticated();
        $response->assertStatus(403);
    }

    public function test_guest_cant_access_edit_idea_page()
    {
        $idea = $this->createIdea();

        $response = $this->get(route('ideas.edit', $idea->id));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_update_idea_with_valid_data()
    {
        $idea = $this->createIdea();
        $newContent = 'New content';

        $response = $this->actingAs($this->user)->put(route('ideas.update', $idea->id), ['content' => $newContent]);

        $this->assertAuthenticated();
        // $response->assertRedirect(route('ideas.show', $idea->id));

        $updatedIdea = Idea::where('id', $idea->id)->first();
        $this->assertEquals($idea->id, $updatedIdea->id);
        $this->assertEquals($newContent, $updatedIdea->content);
    }

    public function test_update_idea_with_invalid_data()
    {
        $idea = $this->createIdea();

        $response = $this->actingAs($this->user)->put(route('ideas.update', $idea->id), ['content' => '']);

        $this->assertAuthenticated();
        $response->assertStatus(302);
        $response->assertInvalid(['content']);
    }

    public function test_unauthorized_user_cant_update_idea()
    {
        $idea = $this->createIdea();
        $unauthorizedUser = $this->createUser();

        $response = $this->actingAs($unauthorizedUser)->put(route('ideas.update', $idea->id), ['content' => 'Test']);

        $this->assertAuthenticated();
        $response->assertStatus(403);
    }

    public function test_guest_cant_update_idea()
    {
        $idea = $this->createIdea();

        $response = $this->put(route('ideas.update', $idea->id), ['content' => 'Test']);

        $this->assertGuest();
        $response->assertRedirect('login');
    }

    public function test_admin_can_update_idea()
    {
        $idea = $this->createIdea();

        $response = $this->actingAs($this->admin)->put(route('ideas.update', $idea->id), ['content' => 'Test']);

        $this->assertAuthenticated();
        $response->assertStatus(302);
    }

    public function test_idea_author_can_delete_idea()
    {
        $idea = $this->createIdea();

        $response = $this->actingAs($this->user)->delete(route('ideas.destroy', $idea->id));

        $response->assertStatus(302);
        $this->assertAuthenticated();
        $this->assertDatabaseMissing('ideas', $idea->toArray());
    }

    public function test_admin_can_delete_idea()
    {
        $idea = $this->createIdea();

        $response = $this->actingAs($this->admin)->delete(route('ideas.destroy', $idea->id));

        $response->assertStatus(302);
        $this->assertAuthenticated();
        $this->assertDatabaseMissing('ideas', $idea->toArray());
    }

    public function test_unauthorized_user_cant_delete_idea()
    {
        $idea = $this->createIdea();
        $unauthorizedUser = $this->createUser();

        $response = $this->actingAs($unauthorizedUser)->delete(route('ideas.destroy', $idea->id));

        $response->assertStatus(403);
        $this->assertAuthenticated();
    }

    public function test_guest_cant_delete_idea()
    {
        $idea = $this->createIdea();

        $response = $this->delete(route('ideas.destroy', $idea->id));

        $response->assertStatus(302);
        $this->assertGuest();
    }

    private function createUser(bool $isAdmin = false): User
    {
        return User::factory()->create(['is_admin' => $isAdmin])->assignRole(RolesEnum::User);
    }

    private function createIdea(): Idea
    {
        return Idea::factory()->create(['user_id' => $this->user->id]);
    }
}
