<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminBtn extends Component
{
    public $title;
    public $routex;
    public $iconURL;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $iconURL, $routex = null)
    {
        $this->title = $title;
        $this->iconURL = $iconURL;
        $this->routex = $routex;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-btn');
    }
}
