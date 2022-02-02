<?php

namespace App\Http\Controllers\Web;

use App\Cause;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CategoryRequest;
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
    public function index(Request $request)
    {
        $type = 'causes';
        $categories = Cause::where('name', 'like', "%{$request->name}%")
            ->orderBy('name', 'asc')
            ->paginate(10);
        return view('categories.index', compact('type', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = 'causes';
        return view('categories.edit', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $cause = new Cause([
            'name'                          => $request->name,
            'fontawesome_icon_unicode'      => $request->fontawesome_icon_unicode
        ]);
        $cause->save();
        return redirect()
            ->route('applications.index')
            ->with('success', 'Causa Salva!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cause  $cause
     * @return \Illuminate\Http\Response
     */
    public function edit(Cause $cause)
    {
        $type = 'causes';
        $category = $cause;
        return view('categories.edit', compact('category', 'type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  \App\Cause  $cause
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Cause $cause)
    {
        $cause->update([
            'name'                          => $request->name,
            'fontawesome_icon_unicode'      => $request->fontawesome_icon_unicode
        ]);

        return redirect()->route('causes.index')->with('success', 'Causa atualizada!');
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
        return redirect()->route('causes.index')->with('success', 'Causa excluída!');
    }
}
