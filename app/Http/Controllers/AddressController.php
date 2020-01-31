<?php

namespace App\Http\Controllers;

use App\State;

class AddressController extends Controller
{
    public function getCitiesByStateId($stateId){
        $cities = [];
        if(State::find($stateId) !== null){
            $cities = State::find($stateId)->cities()->select('id', 'name')->get()->toArray();
        }
        return response()->json($cities);
    }
}
