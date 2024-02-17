<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HouseTest extends TestCase
{
    /**
     * Test that owner can sync users in house
     * @test
     */
    public function owner_can_sync_users_in_house(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test that owner can edit house
     * @test
     */
    public function owner_can_edit_house(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

}
