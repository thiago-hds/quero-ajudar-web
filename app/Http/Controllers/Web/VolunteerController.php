<?php

namespace App\Http\Controllers\Web;

use App\Cause;
use App\Enums\ProfileType;
use App\Skill;
use App\Volunteer;
use App\User;
use App\Http\Requests\Web\VolunteerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class VolunteerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(\App\Volunteer::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        $volunteers = Volunteer::latest()->filter($filters)->paginate(10);

        return view('volunteers.index', compact('volunteers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('volunteers.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\VolunteerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VolunteerRequest $request)
    {
        $attributes = $request->all();
        $attributes['profile'] = ProfileType::VOLUNTEER;
        $attributes['password'] = Hash::make($request->password);

        $user = User::create($attributes);

        $volunteer = new Volunteer();
        $volunteer->user()->associate($user);
        $volunteer->save();

        $volunteer->causes()->sync($request->causes);
        $volunteer->skills()->sync($request->skills);

        return redirect()
            ->route('volunteers.index')
            ->with('success', 'Voluntário salvo!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function edit(Volunteer $volunteer)
    {
        return view('volunteers.edit', compact('volunteer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\VolunteerRequest  $request
     * @param  \App\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function update(VolunteerRequest $request, Volunteer $volunteer)
    {
        $user = User::find($volunteer->user_id);

        $attributes = $request->all();
        if ($request->password != $user->password) {
            $attributes['password'] = Hash::make($request->password);
        }

        $user->update($attributes);

        $volunteer->causes()->sync($request->causes);
        $volunteer->skills()->sync($request->skills);

        return redirect()
            ->route('volunteers.index')
            ->with('success', 'Voluntário atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Volunteer $volunteer)
    {
        $volunteer->causes()->detach();
        $volunteer->skills()->detach();
        $volunteer->user->delete();
        $volunteer->delete();

        return redirect()
            ->route('volunteers.index')
            ->with('success', 'Voluntário excluído!');
    }
}
