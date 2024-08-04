<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_registration_page()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $this->assertGuest();
        $response->assertSeeText(__('auth.register'));
    }

    public function test_registration_with_valid_data()
    {
        $email = 'test@testmail.com';
        $name = 'John Doe';
        $password = 'password123';

        $response = $this->post(route('register'), [
            'email' => $email,
            'name' => $name,
            'password' => $password
        ]);

        // the user must log in after registration, hence the user should appear as guest
        $this->assertGuest();
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => $name,
        ]);

        $lastUser = User::latest()->first();
        $this->assertEquals($name, $lastUser->name);
        $this->assertEquals($email, $lastUser->email);
        $this->assertEquals($password, Hash::check($password, $lastUser->password));
    }

    public function test_registration_with_invalid_data()
    {
        $response = $this->post(route('register'));

        $this->assertGuest();
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_get_login_page()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $this->assertGuest();
        $response->assertSeeText(__('auth.login'));
    }

    public function test_login_with_valid_data()
    {
        $email = 'john@test.com';
        $password = 'password123';

        $user = User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $response = $this->post(route('login'), ['email' => $email, 'password' => $password]);

        $response->assertRedirect(route('dashboard'));
        $this->assertCredentials(['email' => $email, 'password' => $password]);
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_invalid_data()
    {
        $response = $this->post(route('login'));

        $this->assertGuest();
        $response->assertSessionHasErrors(['email']);
    }

    public function test_authenticated_user_logout()
    {
        $oldSesssionId = Session::getId();
        $oldCsrfToken = csrf_token();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('dashboard'));
        $this->assertGuest();
        $this->assertNotEquals($oldSesssionId, Session::getId());
        $this->assertNotEquals($oldCsrfToken, csrf_token());
    }

    public function test_guest_user_logout_redirects_to_login()
    {
        $response = $this->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_cant_access_login_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('login'));

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_authenticated_user_cant_access_registration_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('register'));

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
