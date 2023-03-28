<?php

namespace App\Rules;

use App\Models\Hotel;
use Illuminate\Contracts\Validation\Rule;

class QuantityLessRule implements Rule
{
    public function __construct(public string $quantity, public int $hotel_id)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $hotel = Hotel::with(['room'])->where('id',$this->hotel_id)->first();

        if(count($hotel->room) == 0){
            return true;
        }

        $totalRoom = $hotel->room->sum('quantity');

        $newRooms = $totalRoom + $value;

        if ($newRooms > $hotel->room_number){
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La cantidad de habitaciones supera el maximo permitido parta el hotel seleccionado.';
    }
}
