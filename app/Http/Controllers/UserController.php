<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use App\Organization;

use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
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
            if($input){
                if(in_array($key,['profile','organization','status'])){
                    $whereClauses[] = [$key, '=', $input];
                }
                else{
                    $whereClauses[] = [$key, 'like', $input];
                }
            }
        }

        $organizations = Organization::all();
        $users = DB::table('users')->where($whereClauses)->get();
        $inputs = (object) $inputs;
        return view('users.index', compact('inputs', 'users', 'organizations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizations = Organization::all();

        return view('users.edit', compact('organizations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name'              => 'required',
            'date_of_birth'     => 'required',
            'profile'           => 'required|in:admin,organization',
            'organization'      => 'required_if:profile,organization',
            'email'             => 'required|email',
            'password'          => 'required',
            'password_confirm'  => 'required|same:password',
            'status'            => 'required|in:active,inactive'
        ]);

        $user = new User([
            'name'              => $request->input('name'),
            'date_of_birth'     => $request->input('date_of_birth'),
            'profile'           => $request->input('profile'),
            'organization_id'   => $request->input('profile') == User::ADMIN? null : $request->get('organization'),
            'email'             => $request->input('email'),
            'password'          => Hash::make($request->input('password')),
            'status'            => $request->input('status')
        ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $organizations = Organization::all();

        return view('users.edit', compact('user','organizations'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required',
            'date_of_birth'     => 'required',
            'profile'           => 'required|in:admin,organization',
            'organization'      => 'required_if:profile,organization',
            'email'             => 'required|email',
            'password'          => 'required',
            'password_confirm'  => 'required|same:password',
            'status'            => 'required:in:active,inactive'
        ]);

        $user = User::find($id);
        $user->name             = $request->input('name');
        $user->date_of_birth    = $request->input('date_of_birth');
        $user->profile          = $request->input('profile');
        $user->organization_id  = $request->input('profile') == User::ADMIN? null : $request->input('organization');
        $user->email            = $request->input('email');
        $user->status           = $request->input('status');
        
        if($request->input('password') != $user->password){
            $user->password = Hash::make($request->input('password'));
        }
            
        $user->save();

        return redirect('/users')->with('success', 'Usuário atualizado!');
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
