<?php

namespace Tests\Feature;

use App\Models\Idea;
use App\Models\User;
use Database\Factories\IdeaFactory;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_doesnt_contain_ideas()
    {
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSeeText(__("ideas.no_ideas_created"));
        $this->assertDatabaseEmpty('ideas');
    }

    public function test_dashboard_contains_ideas()
    {
        $user = User::factory()->has(Idea::factory(3))->create();
        $ideas = $user->ideas;

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        // assures that the view has all created ideas
        $response->assertViewHas('ideas', fn ($collection) => ($collection->diff($ideas))->isEmpty());
    }

    public function test_paginated_ideas_table_doesnt_contain_21st_record()
    {
        $user = User::factory()->has(Idea::factory(21))->create();
        $ideas = $user->ideas;

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('ideas', fn ($collection) => $collection->doesntContain($ideas->last()));
    }

    public function test_top_users_doesnt_contain_users()
    {
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee(__('shared.top_users'));
        $response->assertSee(__('shared.no_top_users'));
        $response->assertViewHas('topUsers', fn ($collection) => $collection->isEmpty());
    }

    public function test_top_users_contains_max_5_users()
    {
        $users = User::factory(6)->has(Idea::factory())->create();

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('topUsers', fn ($collection) => $collection->doesntContain($users->last()));
    }

    public function test_top_users_has_the_user_with_most_ideas_at_the_top()
    {
        User::factory(4)->has(Idea::factory())->create();
        $topUser = User::factory()->has(Idea::factory(5))->create();

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('topUsers', fn ($collection) => $collection->first()->is($topUser));
    }

    public function test_guest_cant_see_feed_button_in_left_sidebar()
    {
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $this->assertGuest();
        $response->assertDontSeeText(__('shared.feed'));
    }

    public function test_authenticated_user_can_see_feed_button_in_left_sidebar()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $this->assertAuthenticated();
        $response->assertSeeText(__('shared.feed'));
    }

    public function test_guest_cant_access_feed_page()
    {
        $response = $this->get(route('feed'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_guest_cant_see_submit_idea_form()
    {
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $this->assertGuest();
        $response->assertDontSee('submit-idea-form');
        $response->assertSeeText(__('ideas.login_to_share'));
    }

    public function test_authenticated_user_can_see_submit_idea_form()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $this->assertAuthenticated();
        $response->assertSee('submit-idea-form');
        $response->assertSeeText(__('ideas.share_ideas'));
    }

    private function createUser(int $ideasCount = 0): User
    {
        if ($ideasCount != 0) {
            return User::factory()->has(Idea::factory($ideasCount))->create();
        }

        return User::factory()->create();
    }
}
