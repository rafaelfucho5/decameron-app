<?php

namespace App\Http\Rules;

use App\Enums\RoomAccommodationEnums;
use App\Enums\RoomTypeEnums;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Contracts\Validation\Rule;

class AccommodationTypeRule implements Rule
{
    protected $message;

    public function __construct(public string $type, public int $hotel_id)
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
        $room = Room::query()
            ->where('type',$this->type)
            ->where('accommodation', $value)
            ->where('hotel_id',$this->hotel_id)
            ->first();

        if(!is_null($room)){
            $this->message = 'La acomodación seleccionada ya está asignada a una habitación de este tipo en este hotel.';
            return false;
        }

        switch ($this->type) {
            case RoomTypeEnums::Estandar->value:
                if (!($value === RoomAccommodationEnums::Sencilla->value || $value === RoomAccommodationEnums::Doble->value)) {
                    $this->message = 'La acomodación seleccionada no es válida para el tipo de habitación seleccionado.';
                    return false;
                }
                break;
            case RoomTypeEnums::Junior->value:
                if (!($value === RoomAccommodationEnums::Triple->value || $value === RoomAccommodationEnums::Cuadruple->value)) {
                    $this->message = 'La acomodación seleccionada no es válida para el tipo de habitación seleccionado.';
                    return false;
                }
                break;
            case RoomTypeEnums::Suite->value:
                if (!($value === RoomAccommodationEnums::Sencilla->value || $value === RoomAccommodationEnums::Doble->value || $value === RoomAccommodationEnums::Triple->value)) {
                    $this->message = 'La acomodación seleccionada no es válida para el tipo de habitación seleccionado.';
                    return false;
                }
                break;
            default:
                $this->message = 'La acomodación ya existe para el tipo de habitación seleccionado.';
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
        return $this->message;
    }
}
