<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private User $regularUser;
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->regularUser = User::factory()->create();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_guest_cant_access_admin_routes()
    {
        $this->assertGuest();
        foreach($this->adminRoutes() as $route) {
            $this->get($route)->assertRedirect(route('login'));
        }
    }

    public function test_non_admin_user_cant_access_admin_routes()
    {
        foreach($this->adminRoutes() as $route) {
            $this->actingAs($this->regularUser)->get($route)->assertStatus(403);
        }
    }

    public function test_admin_users_can_access_admin_route()
    {
        foreach($this->adminRoutes() as $route) {
            $this->actingAs($this->admin)->get($route)->assertStatus(200);
        }
    }

    private function adminRoutes(): array
    {
        return [
            route('admin.dashboard'),
            route('admin.ideas'),
            route('admin.users'),
            route('admin.comments')
        ];
    }
}
