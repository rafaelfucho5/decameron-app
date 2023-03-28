<?php

namespace Database\Factories;

use App\Enums\RoomAccommodationEnums;
use App\Enums\RoomEnums;
use App\Enums\RoomTypeEnums;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsRoom>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = RoomTypeEnums::random();
        $accommodation = $this->faker->randomElement($type->getAccommodation());

        return [
            'quantity' => $this->faker->numberBetween(1,10),
            'type' => $type->value,
            'accommodation' =>  $accommodation,
        ];
    }
}
