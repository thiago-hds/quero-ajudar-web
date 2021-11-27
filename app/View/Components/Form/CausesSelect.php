<?php

namespace App\View\Components\Form;

use App\Cause;
use Illuminate\View\Component;

class CausesSelect extends Component
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
            'placeholder' => 'Selecione as causas...',
            'allowClear' => true,
            'multiple' => true
        ];
        $causes = Cause::all();

        return view('components.form.causes-select', compact('config', 'causes'));
    }
}
