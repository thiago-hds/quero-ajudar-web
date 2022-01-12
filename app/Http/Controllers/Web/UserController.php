<?php

namespace App\Http\Controllers\Web;

use App\Enums\ProfileType;
use App\User;
use App\Organization;
use App\Http\Requests\Web\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(\App\User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = request(['name','email','profile', 'organization_id', 'status']);

        if (request()->user()->profile == ProfileType::ORGANIZATION) {
            $filters['organization_id'] = request()->user()->organization_id;
        }

        $users = User::latest()
            ->where('profile', '!=', ProfileType::VOLUNTEER)
            ->filter($filters)
            ->paginate(10);

        return view('users.index', ['users' =>  $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizations = Organization::orderBy('name', 'asc')->get();
        return view('users.edit', compact('organizations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $attributes = $request->all();
        $attributes['password'] = Hash::make($attributes['password']);

        if (!$request->user()->isAdmin()) {
            $attributes['profile'] = ProfileType::ORGANIZATION;
            $attributes['organization_id'] = $request->user()->organization_id;
        }

        User::create($attributes);

        return redirect('/users')->with('success', 'Usuário Salvo!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $organizations = Organization::all();
        return view('users.edit', compact('user', 'organizations'));
    }

    /**
     * Show the form for editing the logged user profile.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = Auth::user();
        $organizations = Organization::all();
        return view('users.edit', compact('user', 'organizations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $attributes = $request->all();

        if ($attributes['password'] != $user->password) {
            $attributes['password'] = Hash::make($attributes['password']);
        }

        if (!$request->user()->isAdmin()) {
            $attributes['profile'] = ProfileType::ORGANIZATION;
            $attributes['organization_id'] = $request->user()->organization_id;
        }

        $user->update($attributes);

        return redirect('/users')->with('success', 'Usuário atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/users')->with('success', 'Usuário excluído!');
    }
}
