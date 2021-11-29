<?php

namespace App\View\Components\Form;

use App\Skill;
use Illuminate\View\Component;

class SkillsSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $config = [
            'placeholder' => 'Selecione as habilidades...',
            'allowClear' => true,
            'multiple' => true
        ];
        $skills = Skill::all();

        return view('components.form.skills-select', compact('config', 'skills'));
    }
}
