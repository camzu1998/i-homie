<?php
namespace Authenticated;

use App\Models\House;
use App\Models\Room;
use App\Services\HouseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Authenticated\AuthenticatedTestCase;

class EntryTest extends AuthenticatedTestCase
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
     * Test user can fetch entries
     * @test
     */
    public function user_can_fetch_entries(): void
    {
        $response = $this->get('/api/entries');
        $response->assertStatus(200);
    }

    /**
     * Test user can create entry
     * @test
     */
    public function user_can_create_entry(): void
    {
        $response = $this->post('/api/entries', [
            'title' => 'Entry Name',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('entries', ['title' => 'Entry Name']);
    }

    /**
     * Test user can update entry
     * @test
     */
    public function user_can_update_entry(): void
    {
        $entries = $this->house->entries()->create([
            'title' => 'Entry Name',
        ]);

        $response = $this->put(route('entries.update', $entries), [
            'title' => 'Entry Test',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('entries', ['title' => 'Entry Test']);
    }

    /**
     * Test user can delete entry
     * @test
     */
    public function user_can_delete_entry(): void
    {
        $entry = $this->house->entries()->create([
            'title' => 'Entry Name',
            'user_id' => $this->user->id,
        ]);

        $response = $this->delete(route('entries.destroy', $entry));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('entries', ['title' => 'Entry Name', 'deleted_at' => null]);
    }
}
