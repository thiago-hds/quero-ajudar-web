<?php

namespace App\Http\Controllers\Web;

use App\Cause;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CauseController extends Controller
{

    public function __construct()
    {   
        $this->middleware('auth');
        $this->authorizeResource(\App\Cause::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $causes = Cause::orderBy('name', 'asc')->paginate(10);
        return view('categories.index', compact('causes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cause = new Cause([
            'name'                          => $request->input('name'),
            'fontawesome_icon_unicode'      => $request->input('fontawesome_icon_unicode')
        ]);
        $cause->save();
        return redirect('/causes')->with('success', 'Causa Salva!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cause  $cause
     * @return \Illuminate\Http\Response
     */
    public function edit(Cause $cause)
    {
        return view('categories.edit', compact('cause'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cause  $cause
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cause $cause)
    {
        $cause->update([
            'name'                          => $request->input('name'),
            'fontawesome_icon_unicode'      => $request->input('fontawesome_icon_unicode')
        ]);

        return redirect('/causes')->with('success', 'Causa atualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cause  $cause
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cause $cause)
    {
        $cause->delete();
        return redirect('/causes')->with('success', 'Causa excluída!');
    }
}
