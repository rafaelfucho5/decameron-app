<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Models\Hotel;
use Illuminate\Validation\Rule;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return responder()->success(Hotel::with('rooms')->get())->respond();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request)
    {

        $hotel = new Hotel;
        $hotel->name = $request->name;
        $hotel->city = $request->city;
        $hotel->room_number = $request->room_number;
        $hotel->nit = $request->nit;
        $hotel->direction = $request->direction;
        $hotel->save();

        return responder()->success($hotel)->respond();
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        return responder()->success($hotel)->respond();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        $validatedData = $request->validate([
            'name' => ['nullable'],
            'city' => ['nullable'],
            'room_number' => ['required','integer'],
            'nit' => ['required','max:12',Rule::unique('hotels', 'nit')->ignore($hotel->id)],
            'direction' => ['nullable']
        ]);
        $hotel->update($validatedData);

        return responder()->success([
            'message' => 'Hotel actualizado correctamente',
            'data' => $hotel,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();

        return responder()->success([
            'message' => 'Hotel eliminado correctamente',
        ]);
    }
}
