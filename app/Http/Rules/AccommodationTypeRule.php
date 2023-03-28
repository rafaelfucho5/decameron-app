<?php

namespace App\Rules;

use App\Enums\RoomAccommodationEnums;
use App\Enums\RoomTypeEnums;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Contracts\Validation\Rule;

class AccommodationTypeRule implements Rule
{
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
            return $this->message('not_unique');
        }

        switch ($this->type) {
            case RoomTypeEnums::Estandar->value:
                if (!($value === RoomAccommodationEnums::Sencilla->value || $value === RoomAccommodationEnums::Doble->value)) {
                    return $this->message('not_valid');
                }
                break;
            case RoomTypeEnums::Junior->value:
                if (!($value === RoomAccommodationEnums::Triple->value || $value === RoomAccommodationEnums::Cuadruple->value)) {
                    return $this->message('not_valid');
                }
                break;
            case RoomTypeEnums::Suite->value:
                if (!($value === RoomAccommodationEnums::Sencilla->value || $value === RoomAccommodationEnums::Doble->value || $value === RoomAccommodationEnums::Triple->value)) {
                    return $this->message('not_valid');
                }
                break;
            default:
                return $this->message('not_valid');
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message($message = null)
    {
        switch ($message) {
            case 'not_unique':
                return 'La acomodación seleccionada ya está asignada a una habitación de este tipo en este hotel.';
            case 'not_valid':
                return 'La acomodación seleccionada no es válida para el tipo de habitación seleccionado.';
            default:
                return 'La acomodación seleccionada no es válida para el tipo de habitación seleccionado.';
        }
    }
}
