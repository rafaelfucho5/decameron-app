<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotels = Hotel::get();

        Room::factory()->create([
            'hotel_id' => $hotels->first()->id
        ]);

        Room::factory()->create([
            'hotel_id' => $hotels->skip(1)->take(1)->first()->id
        ]);

        Room::factory()->create([
            'hotel_id' => $hotels->skip(2)->take(1)->first()->id
        ]);
    }

}
