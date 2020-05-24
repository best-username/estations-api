<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Station;

class StationTest extends TestCase
{
    public function testsStationAreCreatedCorrectly()
    {
        $payload = [
            'name' => 'Lorem',
            'isOpen' => 1,
            'latitude' => 123,
            'longitude' => 123,
            'city_id' => 1,
        ];

        $this->json('POST', '/api/station', $payload)
            ->assertStatus(200)
            ->assertJson(["success" => true]);
    }

    public function testsStationAreUpdatedCorrectly()
    {
        $station = factory(Station::class)->create([
            'name' => 'First',
        ]);

        $payload = [
            'name' => 'First',
        ];

        $response = $this->json('PUT', '/api/station/' . $station->id, $payload)
            ->assertStatus(200)
            ->assertJson(["success" => true]);
    }

    public function testsStationAreDeletedCorrectly()
    {
        $station = factory(Station::class)->create([
            'name' => 'First',
        ]);

        $this->json('DELETE', '/api/station/' . $station->id, [])
            ->assertJson(["success" => true]);
    }
}