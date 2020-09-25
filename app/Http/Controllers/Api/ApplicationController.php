<?php

namespace App\Http\Controllers\Api;

use App\Application;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ApplicationRequest;
use App\Http\Resources\Api\ApplicationResource;
use App\Phone;
use App\Vacancy;
use App\Volunteer;
use Exception;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends BaseController
{
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationRequest $request)
    {
        $volunteer  = Volunteer::find(Auth::user()->id);
        $vacancy    = Vacancy::find($request->input('vacancy_id'));
        
        try{
            $application = new Application();
            $application->volunteer()->associate($volunteer);
            $application->vacancy()->associate($vacancy);
            $application->save();

            $application->phone()->save(
                new Phone(['number' => $request->input('volunteer_phone')])
            );
        }
        catch(Exception $ex){
            return $this->sendFail('Não foi possível salvar se inscrever na vaga');
        }
        return $this->sendResponse(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
