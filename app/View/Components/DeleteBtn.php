<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DeleteBtn extends Component
{
    public $tooltip;
    public $id;
    public $text;
    public $elemID;
    public $elemName;
    public $routeName;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tooltip, $id, $text, $elemName, $routeName)
    {
        $this->tooltip = $tooltip;
        $this->id = $id;
        $this->text = $text;
        $this->elemName = $elemName;
        $this->elemID = $elemName.$id[0];
        $this->routeName = $routeName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.delete-btn');
    }
}
