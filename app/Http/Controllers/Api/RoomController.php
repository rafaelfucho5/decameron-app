<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Hotel $hotel)
    {
        return responder()->success($hotel->rooms()->get())->respond();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request, Hotel $hotel)
    {
        $room = new Room;
        $room->type = $request->type;
        $room->quantity = $request->quantity;
        $room->accommodation = $request->accommodation;
        $room->hotel_id = $hotel->id;
        $room->save();

        return responder()->success($room)->respond();
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel, Room $room)
    {
        return responder()->success($room)->respond();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
