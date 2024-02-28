<?php
namespace Tests\Feature\Authenticated;

use App\Models\House;
use App\Models\Room;
use App\Services\HouseService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DutiesTest extends AuthenticatedTestCase
{
    use RefreshDatabase;
    private House $house;
    private Room $room;
    protected function setUp(): void
    {
        parent::setUp();

        $this->house = (new HouseService())->setUser()->create(['name' => 'First Name'])->getHouse();
        $this->room = $this->house->rooms()->create(['name' => 'Room Name']);
    }
    /**
     * Test user can fetch duties
     * @test
     */
    public function user_can_fetch_duties(): void
    {
        $response = $this->get('/api/duties');
        $response->assertStatus(200);
    }

    /**
     * Test user can create duty
     * @test
     */
    public function user_can_create_duty(): void
    {
        $response = $this->post('/api/duties', [
            'name' => 'Duty Name',
            'status' => 'active',
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'frequency' => 'daily',
            'start_date' => '2024-01-01',
            'end_date' => '2025-01-01',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('duties', ['name' => 'Duty Name']);
    }

    /**
     * Test user can update duty
     * @test
     */
    public function user_can_update_duty(): void
    {
        $duty = $this->house->duties()->create([
            'name' => 'Duty Name',
            'status' => 'active',
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'frequency' => 'daily',
            'start_date' => '2024-01-01',
            'end_date' => '2025-01-01',
        ]);

        $response = $this->put(route('duties.update', $duty), [
            'name' => 'Duty Test',
            'status' => 'active',
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'frequency' => 'daily',
            'start_date' => '2024-01-01',
            'end_date' => '2025-01-01',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('duties', ['name' => 'Duty Test']);
    }

    /**
     * Test user can delete duty
     * @test
     */
    public function user_can_delete_duty(): void
    {
        $duty = $this->house->duties()->create([
            'name' => 'Duty Name',
            'status' => 'active',
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'frequency' => 'daily',
            'start_date' => '2024-01-01',
            'end_date' => '2025-01-01',
        ]);

        $response = $this->delete(route('duties.destroy', $duty));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('duties', ['name' => 'Duty Name']);
    }
}
