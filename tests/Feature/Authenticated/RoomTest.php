<?php
namespace Tests\Feature\Authenticated;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Authenticated\AuthenticatedTestCase;
use Tests\TestCase;

class RoomTest extends AuthenticatedTestCase
{
    /**
     * Test user can fetch rooms
     * @test
     */
    public function user_can_fetch_rooms(): void
    {
        $response = $this->get('/rooms');
        $response->assertStatus(200);
    }

    /**
     * Test user can create room
     * @test
     */
    public function user_can_create_room(): void
    {
        $response = $this->post('/rooms', [
            'name' => 'Room Name',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('rooms', ['name' => 'Room Name']);
    }

    /**
     * Test user can update room
     * @test
     */
    public function user_can_update_room(): void
    {
        $room = $this->user->rooms()->create(['name' => 'Room Name']);

        $response = $this->put(route('rooms.update', $room), [
            'name' => 'Room Test',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('rooms', ['name' => 'Room Test']);
    }

    /**
     * Test user can delete room
     * @test
     */
    public function user_can_delete_room(): void
    {
        $room = $this->user->rooms()->create(['name' => 'Room Name']);

        $response = $this->delete(route('rooms.destroy', $room));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('rooms', ['name' => 'Room Name']);
    }
}
