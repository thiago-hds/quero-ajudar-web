<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organization;


class WebController extends Controller
{
    public function login()
    {
        $organizations = Organization::all();

        echo $organizations;

        //return view('login');
    }
}
