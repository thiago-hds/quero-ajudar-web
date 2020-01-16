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
            'birth_date'        => 'required',
            'profile'           => 'required|in:admin,organization',
            'organization'      => 'required_if:profile,organization|exists:organizations,id',
            'email'             => 'required|email',
            'password'          => 'required',
            'password_confirm'  => 'required|same:password'
        ]);
        return $request;
        $user = new User([
            'name'              => $request->get('name'),
            'birth'             => $request->get('birth_date'),
            'profile'           => $request->get('profile'),
            'organization_id'   => $request->get('profile') == User::Admin? null : $request->get('organization'),
            'email'             => $request->get('email'),
            'password'          => Hash::make($request->get('password')),
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
        //
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
