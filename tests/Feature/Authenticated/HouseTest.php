<?php

namespace Tests\Feature\Authenticated;

use App\Models\User;

class HouseTest extends AuthenticatedTestCase
{
    /**
     * Test that user can create house
     * @test
     */
    public function user_can_create_house(): void
    {
        $response = $this->get('/api/houses');
        $response->assertStatus(200);

        $response = $this->post('/api/houses', [
            'name' => 'House Name',
        ]);

        $response->assertStatus(200);//->assertJsonFragment(['name' => 'House Name']);
        $this->assertDatabaseHas('houses', ['name' => 'House Name']);
    }

    /**
     * Test that owner can sync users in house
     * @test
     */
    public function owner_can_sync_users_in_house(): void
    {
        $users = User::factory()->count(3)->create();
        $usernames = $users->pluck('name')->toArray();
        $house = $this->user->ownHouses()->create(['name' => 'House Name']);

        $response = $this->put(route('houses.update', $house), [
            'name' => 'House Name',
            'users' => $usernames
        ]);
        $response->assertStatus(200);//->assertJsonFragment(['status' => 'success']);
        $this->assertDatabaseHas('house_user', ['user_id' => 3]);
        unset($usernames[0]);
        $response = $this->put(route('houses.update', $house), [
            'name' => 'House Name',
            'users' => $usernames
        ]);
        $response->assertStatus(200);//->assertJsonFragment(['status' => 'success']);
        $this->assertDatabaseMissing('house_user', ['user_id' => 3]);
    }

    /**
     * Test that owner can edit house
     * @test
     */
    public function owner_can_edit_house(): void
    {
        $house = $this->user->ownHouses()->create(['name' => 'House Name']);

        $response = $this->put(route('houses.update', $house), [
            'name' => 'House Test',
        ]);
        $response->assertStatus(200);//->assertJsonFragment(['name' => 'House Test']);
        $this->assertDatabaseHas('houses', ['name' => 'House Test']);
    }

}
