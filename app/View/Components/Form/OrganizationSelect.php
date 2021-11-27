<?php

namespace App\View\Components\Form;

use App\Organization;
use Illuminate\View\Component;

class OrganizationSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $selected)
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $config = [
            'placeholder' => 'Selecione uma instituição...',
            'allowClear' => true,
        ];
        $organizations = Organization::all();

        return view('components.form.organization-select', compact('config', 'organizations'));
    }
}
