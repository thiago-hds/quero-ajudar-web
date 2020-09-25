<?php

namespace App\Http\Controllers\Web;

use App\Application;
use App\Enums\StatusType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Organization;
use App\Vacancy;
use App\Volunteer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stats = (object) [
            'organization_count'    => Organization::where('status', StatusType::ACTIVE)->count(),
            'vacancy_count'         => Vacancy::where('status', StatusType::ACTIVE)->count(),
            'volunteer_count'       => Volunteer::all()->count(),
            'application_count'      => Application::all()->count()
        ];
        
        return view('home', compact('stats'));
    }
}
