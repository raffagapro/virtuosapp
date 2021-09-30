<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProfilePanel extends Component
{
    public $user;
    public $monitor;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user, $monitor = false)
    {
        $this->user = $user;
        $this->monitor = $monitor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.profile-panel');
    }
}
