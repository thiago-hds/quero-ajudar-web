<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    public function index()
    {
        //$contacts = Contact::all();

        //return view('contacts.index', compact('contacts'));

        return view('users.index');
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
            'name'              => $request->get('name'),
            'date_of_birth'     => $request->get('date_of_birth'),
            'profile'           => $request->get('profile'),
            'organization_id'   => $request->get('profile') == User::ADMIN? null : $request->get('organization'),
            'email'             => $request->get('email'),
            'password'          => Hash::make($request->get('password')),
            'status'            => $request->get('status')
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
        $user->name             = $request->get('name');
        $user->date_of_birth    = $request->get('date_of_birth');
        $user->profile          = $request->get('profile');
        $user->organization_id  = $request->get('profile') == User::ADMIN? null : $request->get('organization');
        $user->email            = $request->get('email');
        $user->status           = $request->get('status');
        
        if($request->get('password') != $user->password){
            $user->password = Hash::make($request->get('password'));
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
