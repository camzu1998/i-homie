<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user login page and authentication
     * @test
     */
    public function user_can_login(): void
    {
        $user = User::factory()->create();
        $response = $this->get('/');
        $response->assertStatus(200);// Cannot see because it's rendered by vue.js ->assertSee('Login');

        $request = $this->post('/login', [
                'email' => $user->email,
                'password' => 'password'
            ]);
        $request->assertStatus(200)->assertJsonFragment(['name' => $user->name]);
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
        $response->assertStatus(200);// Cannot see because it's rendered by vue.js ->assertSee('Register');

        $request = $this->post('/register', [
            'name' => 'register test',
            'email' => 'register@test.com',
            'password' => 'password'
        ]);
        $request->assertStatus(200)->assertJsonFragment(['status' => 'success']);
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
        $response->assertStatus(200)->assertJsonFragment(['status' => 'success']);
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
        $response = $this->get('/profile');
        $response->assertStatus(200);// Cannot see because it's rendered by vue.js ->assertSee('Edit Profile');

        $request = $this->put(route('users.update', $user), [
            'name' => 'Test User'
        ]);
        $request->assertStatus(200)->assertJsonFragment(['name' => 'Test User']);
        $this->assertDatabaseHas('users', ['name' => 'Test User']);
    }
}
