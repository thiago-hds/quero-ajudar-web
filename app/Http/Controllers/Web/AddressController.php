<?php

namespace App\Http\Controllers\Web;

use App\State;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function getCitiesByStateAbbr($stateAbbr)
    {
        $cities = [];
        $state = State::where('abbr', $stateAbbr)->first();
        if ($state !== null) {
            $cities = $state->cities()->select('id', 'name')->get()->toArray();
        }
        return response()->json($cities);
    }
}
