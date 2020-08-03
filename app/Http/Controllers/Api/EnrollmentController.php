<?php

namespace App\Http\Controllers\Api;

use App\Enrollment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\EnrollmentRequest;
use App\Http\Resources\Api\EnrollmentResource;
use App\Phone;
use App\Vacancy;
use App\Volunteer;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends BaseController
{
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EnrollmentRequest $request)
    {
        $volunteer  = Volunteer::find(Auth::user()->id);
        $vacancy    = Vacancy::find($request->input('vacancy_id'));
        
        $enrollment = new Enrollment();
        $enrollment->volunteer()->associate($volunteer);
        $enrollment->vacancy()->associate($vacancy);
        $enrollment->save();

        $enrollment->phone()->save(
            new Phone(['number' => $request->input('volunteer_phone')])
        );

        return $this->sendResponse(EnrollmentResource::make($enrollment));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
