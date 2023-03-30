<?php

namespace Tests\Feature;

use App\Enums\RoomAccommodationEnums;
use App\Enums\RoomTypeEnums;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as FakerFactory;


class RoomTest extends TestCase
{
    use RefreshDatabase;

    protected $faker;

    public string $route;

    protected function setUp(): void
    {
        parent::setUp();

        $this->route = config('app.url');

        $this->faker = FakerFactory::create();

    }

    /** @test */
    public function test_get_rooms(): void
    {
        $hotel = Hotel::factory()->create();
        Room::factory()->create(['hotel_id' => $hotel->id]);

        $response = $this->get("{$this->route}/api/hotels/{$hotel->id}/rooms");
        $response->assertSuccessful();
        $response->assertJsonCount(3);
        $response->assertJsonFragment([
            'id' => Room::first()->id,
            'quantity' => Room::first()->quantity,
            'type' => Room::first()->type,
            'accommodation' => Room::first()->accommodation,
            'hotel_id' => $hotel->id
        ]);
    }

    /** @test */
    public function test_create_room()
    {
        $hotel = Hotel::factory()->create();

        $data = [
            'quantity' => $this->faker->unique()->numberBetween(1, $hotel->room_number),
            'type' => RoomTypeEnums::Estandar->value,
            'accommodation' => RoomAccommodationEnums::Doble->value,
            'hotel_id' => $hotel->id,
        ];

        $response = $this->post("{$this->route}/api/hotels/{$hotel->id}/rooms", $data);

        $body = json_decode($response->getContent())->data;

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Habitacion creada correctamente',
                'data' => [
                    'quantity' => $data['quantity'],
                    'type' => $data['type'],
                    'accommodation' => $data['accommodation'],
                    'hotel_id' => $data['hotel_id'],
                    "updated_at" => $body->data->updated_at,
                    "created_at" => $body->data->created_at,
                    "id" => $body->data->id,
                ]
            ]);

            $this->assertDatabaseHas('rooms', $data);

    }

    /** @test */
    public function test_create_with_error_room()
    {
        $hotel = Hotel::factory()->create();

        $data = [
            'quantity' => $this->faker->unique()->numberBetween(1, $hotel->room_number),
            'type' => RoomTypeEnums::Estandar->value,
            'accommodation' => RoomAccommodationEnums::Cuadruple->value,
            'hotel_id' => $hotel->id,
        ];

        $response = $this->post("{$this->route}/api/hotels/{$hotel->id}/rooms", $data);
        $response->assertSessionHasErrors();

        $response->assertSessionHasErrors(['accommodation' => 'La acomodación seleccionada no es válida para el tipo de habitación seleccionado.']);

    }

    /** @test */
    public function test_update_room()
    {
        $hotel = Hotel::factory()->create();
        $room = Room::factory()->create(['hotel_id' => $hotel->id]);

        $data = [
            'quantity' => $this->faker->unique()->numberBetween(1, $hotel->room_number),
            'type' => RoomTypeEnums::Estandar->value,
            'accommodation' => RoomAccommodationEnums::Sencilla->value,
        ];

        $response = $this->put("{$this->route}/api/hotels/{$hotel->id}/rooms/{$room->id}", $data);

        $body = json_decode($response->getContent())->data;

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Habitacion actualizada correctamente',
                'data' => [
                    'quantity' => $data['quantity'],
                    'type' => $data['type'],
                    'accommodation' => $data['accommodation'],
                    'hotel_id' => $hotel->id,
                    "updated_at" => $body->data->updated_at,
                    "created_at" => $body->data->created_at,
                    "id" => $body->data->id,
                    "deleted_at" => null
                ]
            ]);
    }

    /** @test */
    public function test_delete_room()
    {
        $hotel = Hotel::factory()->create();
        $room = Room::factory()->create(['hotel_id' => $hotel->id]);

        $response = $this->delete("{$this->route}/api/hotels/{$hotel->id}/rooms/{$room->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Habitacion eliminada correctamente',
                ]);
    }
}
