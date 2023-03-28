<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Models\Hotel;
use App\Models\Room;

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
        dd($request);
        $room = new Room;
        $room->type = $request->type;
        $room->number = $request->number;
        $room->description = $request->description;
        $room->accommodation = $request->accommodation;
        $room->hotel_id = $hotel->id;
        $room->save();

        return responder()->success($room)->respond();
    }
}
