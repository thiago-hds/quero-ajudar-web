<?php

namespace App\View\Components\Form;

use App\Address;
use App\State;
use Illuminate\View\Component;

class AddressPanel extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?Address $address)
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
        $states = State::orderBy('name')->get();
        return view('components.form.address-panel', compact('states'));
    }
}
