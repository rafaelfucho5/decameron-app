<?php

namespace App\Http\Requests;

use App\Enums\RoomTypeEnums;
use App\Rules\AccommodationTypeRule;
use App\Rules\QuantityLessRule;
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
            'quantity' => ['required', 'integer', 'min:1', new QuantityLessRule($this->quantity, $this->hotel_id)],
            'type' => ['required', 'string', Rule::in(RoomTypeEnums::getAllValues())],
            'accommodation' => ['required', 'string', new AccommodationTypeRule($this->type, $this->hotel_id)],
            'hotel_id' => ['required', 'exists:hotels,id'],
        ];
    }
}
