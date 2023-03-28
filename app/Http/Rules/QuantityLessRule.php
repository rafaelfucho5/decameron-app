<?php

namespace App\Http\Rules;

use App\Models\Hotel;
use Illuminate\Contracts\Validation\Rule;

class QuantityLessRule implements Rule
{
    public Hotel $hotel;

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
        $this->hotel = Hotel::with(['rooms'])->where('id',$this->hotel_id)->first();

        if(count($this->hotel->rooms) == 0){
            return true;
        }

        $totalRoom = $this->hotel->rooms->sum('quantity');

        $newRooms = $totalRoom + $value;

        if ($newRooms > $this->hotel->room_number){
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
        return "La cantidad de habitaciones supera el maximo {$this->hotel->room_number} permitido parta el hotel seleccionado.";
    }
}
