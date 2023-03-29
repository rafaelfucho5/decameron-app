<?php

namespace App\Http\Requests;

use App\Enums\RoomTypeEnums;
use App\Http\Rules\AccommodationTypeRule;
use App\Http\Rules\QuantityLessRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'quantity' => ['required', 'integer', 'min:1', new QuantityLessRule($this->quantity, $this->hotel->id)],
            'type' => ['required', 'string', Rule::in(RoomTypeEnums::getAllValues())],
            'accommodation' => ['required', 'string', new AccommodationTypeRule($this->type, $this->hotel->id)],
        ];
    }

    public function messages()
    {
        return [
            'type.in' => 'El tipo de habitación seleccionado no es válido.',
            'accommodation.in' => 'La acomodación seleccionada no es válida.',
            'quantity.min' => 'La cantidad de habitaciones debe ser al menos 1.',
            'quantity.less' => 'La cantidad de habitaciones supera el máximo permitido para el hotel seleccionado.'
        ];
    }
}
