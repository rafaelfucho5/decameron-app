<?php

namespace Tests\Feature;

use App\Models\Hotel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HotelTest extends TestCase
{
    use RefreshDatabase;

    public string $route = 'http://localhost/';

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function test_get_hotels(): void
    {
        Hotel::factory()->count(3)->create();

        $response = $this->get("{$this->route}api/hotels");
        $response->assertSuccessful();
        $response->assertJsonCount(3);
        $response->assertJsonFragment([
            'id' => Hotel::first()->id,
            'name' => Hotel::first()->name,
            'city' => Hotel::first()->city,
        ]);
    }

    /** @test */
    public function test_create_hotel()
    {
        $data = [
            'name' => 'Hotel Test',
            'city' => 'Test City',
            'room_number' => 10,
            'nit' => '1234567890',
            'direction' => 'Test Direction',
        ];

        $response = $this->post("{$this->route}api/hotels", $data);

        $body = json_decode($response->getContent())->data;

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Hotel creado correctamente',
                'data' => [
                    'name' => $data['name'],
                    'city' => $data['city'],
                    'room_number' => $data['room_number'],
                    'nit' => $data['nit'],
                    'direction' => $data['direction'],
                    "updated_at" => $body->data->updated_at,
                    "created_at" => $body->data->created_at,
                    "id" => $body->data->id,
                ]
            ]);
    }

    /** @test */
    public function test_udate_hotel()
    {
        $hotel = Hotel::factory()->create();

        $data = [
            'name' => 'New Name',
            'city' => 'New City',
            'room_number' => 20,
            'nit' => '0987654321',
            'direction' => 'New Direction',
        ];

        $response = $this->put("{$this->route}api/hotels/{$hotel->id}", $data);

        $body = json_decode($response->getContent())->data;

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Hotel actualizado correctamente',
                'data' => [
                    'name' => $data['name'],
                    'city' => $data['city'],
                    'room_number' => $data['room_number'],
                    'nit' => $data['nit'],
                    'direction' => $data['direction'],
                    "updated_at" => $body->data->updated_at,
                    "created_at" => $body->data->created_at,
                    "id" => $body->data->id,
                    "deleted_at" => null
                ]
            ]);
    }

    /** @test */
    public function test_delete_hotel()
    {
        $hotel = Hotel::factory()->create();

        $response = $this->delete("{$this->route}api/hotels/{$hotel->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Hotel eliminado correctamente',
                ]);
    }
}
