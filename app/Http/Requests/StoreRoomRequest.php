<?php

namespace App\Http\Requests;

use App\Enums\RoomTypeEnums;
use App\Http\Rules\AccommodationTypeRule;
use App\Http\Rules\QuantityLessRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => ['required', 'integer', 'min:1', new QuantityLessRule($this->quantity, $this->hotel->id)],
            'type' => ['required', 'string', Rule::in(RoomTypeEnums::getAllValues())],
            'accommodation' => ['required', 'string', new AccommodationTypeRule($this->type, $this->hotel->id)],
            'hotel_id' => ['required', 'exists:hotels,id'],
        ];
    }

    public function messages()
    {
        return [
            'quantity.required' => 'La cantidad de habitacion es obligatorio',
            'type.required' => 'El tipo de habitacion es obligatoria',
            'type.in' => 'El tipo de habitacion es invalido obligatorio',
            'accommodation.required' => 'La acomodacion de habitacion es obligatorio',
            'hotel_id.required' => 'El id del hotel es obligatorio',
            'hotel_id.exists' => 'El id del hotel no existe',
        ];
    }
}
