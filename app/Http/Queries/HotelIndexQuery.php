<?php

namespace App\Http\Queries;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelIndexQuery
{
    /**
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        return Hotel::query()
                    ->with([
                        'room'
                    ])->all();

    }
}
