<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHotelRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => ['nullable'],
            'city' => ['nullable'],
            'room_number' => ['required','integer'],
            'nit' => ['required','max:12',Rule::unique('hotels', 'nit')->ignore($this->hotel->id)],
            'direction' => ['nullable']
        ];
    }

    public function messages()
    {
        return [
            'room_number.required' => 'El número de habitaciones es obligatorio',
            'nit.required' => 'El NIT del hotel es obligatorio',
            'nit.unique' => 'El NIT del hotel ya esta registrado',
        ];
    }
}
