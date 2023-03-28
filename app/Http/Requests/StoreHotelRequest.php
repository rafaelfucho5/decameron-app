<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'city' => 'required|max:255',
            'room_number' => 'required|integer',
            'nit' => 'required|max:12|unique:hotels,nit',
            'direction' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del hotel es obligatorio',
            'city.required' => 'La ciudad del hotel es obligatoria',
            'room_number.required' => 'El número de habitaciones es obligatorio',
            'nit.required' => 'El NIT del hotel es obligatorio',
            'nit.unique' => 'El NIT del hotel ya esta registrado',
            'direction.required' => 'La dirección del hotel es obligatoria',
        ];
    }

}
