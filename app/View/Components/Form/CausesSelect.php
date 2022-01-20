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
    public function __construct(public $selectedValues = [], public $multiple = true)
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
            'placeholder' => $this->multiple ? 'Selecione as causas...' : 'Selecione uma causa',
            'allowClear' => true,
            'multiple' => $this->multiple
        ];
        $causes = Cause::all();

        return view('components.form.causes-select', compact('config', 'causes'));
    }
}
