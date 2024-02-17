<?php

namespace Tests\Feature\Authenticated;

use App\Models\User;

class HouseTest extends AuthenticatedTestCase
{
    /**
     * Test that owner can sync users in house
     * @test
     */
    public function owner_can_sync_users_in_house(): void
    {
        User::factory()->count(3)->create();
        $response = $this->get('/house');
        $response->assertStatus(200);

        $response = $this->post('/house', [
            'users' => [2, 3, 4]
        ]);
        $response->assertStatus(200)->assertJsonFragment(['status' => 'success']);

        $this->assertDatabaseHas('house_user', ['user_id' => 2]);
    }

    /**
     * Test that owner can edit house
     * @test
     */
    public function owner_can_edit_house(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->put('/house', [
            'name' => 'House Name',
        ]);
        $response->assertStatus(200)->assertJsonFragment(['name' => 'House Name']);
        $this->assertDatabaseHas('houses', ['name' => 'House Name']);
    }

}
