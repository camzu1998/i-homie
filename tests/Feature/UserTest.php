<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test user login page and authentication
     * @test
     */
    public function user_can_login(): void
    {
        $user = User::factory()->create();
        $response = $this->get('/');
        $response->assertStatus(200)->assertSee('Login');

        $request = $this->post('/login', [
                'email' => $user->email,
                'password' => 'password'
            ]);
        $request->assertStatus(302);
        $this->assertAuthenticatedAs($user);
        //Todo: Check remember me
    }

    /**
     * Test user register page and registration
     * @test
     */
    public function user_can_register()
    {
        $response = $this->get('/register');
        $response->assertStatus(200)->assertSee('Register');

        $request = $this->post('/register', [
            'email' => 'register@test.com',
            'password' => 'password'
        ]);
        $request->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => 'register@test.com']);
        //Todo: Check email verification
    }

    /**
     * Test user can logout
     * @test
     */
    public function user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/logout');
        $response->assertStatus(302);
        $this->assertGuest();
    }

    /**
     * Test user edit page and update process
     * @test
     */
    public function user_can_edit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/user/edit');
        $response->assertStatus(200)->assertSee('Edit Profile');

        $request = $this->put('/user/edit', [
            'name' => 'Test User'
        ]);
        $request->assertStatus(302)->assertSessionHas('success', 'Profile updated successfully');
        $this->assertDatabaseHas('users', ['name' => 'Test User']);
    }
}
