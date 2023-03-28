<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHotelRequest;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return responder()->success(Hotel::with(['rooms'])->get())->respond();
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
    public function update(Request $request, Hotel $hotel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        //
    }
}
