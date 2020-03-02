<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Organization;
use App\Http\Requests\Web\UserRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function index(Request $request)
    {
        // separacao dos campos de filtragem por tipo de comparacao
        $equalFields    =   ['profile', 'organization_id', 'status']; 
        $likeFields     =   ['name', 'email'];
        
        $inputs = $request->all();

        // definir clausulas where
        $whereClauses = [['profile','!=', 'volunteer']];

        if(Auth::user()->profile == User::ORGANIZATION){
            $inputs['organization_id'] = Auth::user()->organization_id;
        }

        foreach($inputs as $key => $input){
            if($input && in_array($key, array_merge($equalFields, $likeFields))){
                if(in_array($key,$equalFields)){
                    $whereClauses[] = [$key, '=', $input];
                }
                else{
                    $whereClauses[] = [$key, 'like', '%'.$input.'%'];
                }
            }
        }

        // retornar view com dados
        $inputs = (object) $inputs;
        $users = User::where($whereClauses)->orderBy('first_name', 'asc')->paginate(10);
        $organizations = Organization::orderBy('name', 'asc')->get();
        
        return view('users.index', compact('inputs', 'users', 'organizations'));
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
        $user = new User([
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'date_of_birth'     => $request->input('date_of_birth'),
            'profile'           => Auth::user()->isAdmin()? $request->input('profile') : User::ORGANIZATION,
            'email'             => $request->input('email'),
            'password'          => Hash::make($request->input('password')),
            'status'            => $request->input('status')
        ]);
        
        if(!Auth::user()->isAdmin()){
            $organization = Organization::find(Auth::user()->organization_id);
        }
        elseif($user->profile == User::ORGANIZATION){
            $organization = Organization::find($request->input('organization_id'));
        }

        if(isset($organization)){
            $user->organization()->associate($organization);
        }

        $user->save();
        return redirect('/users')->with('success', 'Usuário Salvo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        return view('users.edit', compact('user','organizations'));   
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
        $user->update([
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'date_of_birth'     => $request->input('date_of_birth'),
            'profile'           => Auth::user()->isAdmin()? $request->input('profile') : User::ORGANIZATION,
            'email'             => $request->input('email'),
            'status'            => $request->input('status')
        ]);
        
        if(!Auth::user()->isAdmin()){
            $organization = Organization::find(Auth::user()->organization_id);
        }
        elseif($user->profile == User::ORGANIZATION){
            $organization = Organization::find($request->input('organization_id'));
        }

        if(isset($organization)){
            $user->organization()->associate($organization);
        }
        
        if($request->input('password') != $user->password){
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

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
