<?php

namespace App\Http\Controllers\Web;

use App\Skill;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class SkillController extends Controller
{

    public function __construct()
    {   
        $this->middleware('auth');
        $this->authorizeResource(\App\Skill::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $inputs = (object) $request->all();
        if(!isset($inputs->name)){
            $inputs->name = '';
        }
        $type = 'skills';
        $categories = Skill::where('name','like', '%'. $inputs->name.'%')->orderBy('name', 'asc')->paginate(10);
        return view('categories.index', compact('type','categories', 'inputs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = 'skills';
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
        $skill = new Skill([
            'name'                          => $request->input('name'),
            'fontawesome_icon_unicode'      => $request->input('fontawesome_icon_unicode')
        ]);
        $skill->save();
        return redirect('/skills')->with('success', 'Habilidade Salva!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        $type = 'skills';
        $category = $skill;
        return view('categories.edit', compact('category', 'type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Skill $skill)
    {
        $skill->update([
            'name'                          => $request->input('name'),
            'fontawesome_icon_unicode'      => $request->input('fontawesome_icon_unicode')
        ]);

        return redirect('/skills')->with('success', 'Habilidade atualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect('/skills')->with('success', 'Habilidade excluída!');
    }
}
