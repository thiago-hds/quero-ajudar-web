<?php

namespace App\Http\Controllers\Web;

use App\Vacancy;
use App\Volunteer;
use App\Enrollment;
use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollmentRequest;
use App\Http\Requests\Web\EnrollmentRequest as WebEnrollmentRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class EnrollmentController extends Controller
{

    public function __construct()
    {   
        $this->middleware('auth');
        $this->authorizeResource(\App\Enrollment::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $inputs = $request->all();

        // definir clausulas where
        $whereClauses = [];
        foreach($inputs as $key => $input){
            if($input && in_array($key, ['volunteer_user_id', 'vacancy_id'])){
                $whereClauses[] = [$key, '=', $input];
            }
        }

        // retornar view com dados
        $inputs = (object) $inputs;
        $enrollments = Enrollment::where($whereClauses)->paginate(10);
        $vacancies  = Vacancy::orderBy('name')->get();
        $volunteers = Volunteer::all();

        return view('enrollments.index', compact('inputs', 'enrollments', 'vacancies', 'volunteers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vacancies = Vacancy::where('status',StatusType::ACTIVE)->orderBy('name')->get();
        $volunteers = Volunteer::whereHas('user', function (Builder $query) {
            $query->where('status', StatusType::ACTIVE);
        })->get();


        return view('enrollments.edit', compact('vacancies', 'volunteers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WebEnrollmentRequest $request)
    {
        $enrollment = new Enrollment;
        $enrollment->vacancy()->associate(Vacancy::find($request->input('vacancy_id')));
        $enrollment->volunteer()->associate(Volunteer::find($request->input('volunteer_user_id')));
        $enrollment->save();

        return redirect('/enrollments')->with('success', 'Inscrição salva!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function destroy($enrollment)
    {
        $enrollment->delete();
    }
}
