<?php

namespace App\View\Components\Teacher;

use Illuminate\View\Component;

class HomeworkTab extends Component
{
    public $user;
    public $homeworks;
    public $monitor;
    public $date;
    public $activasCounter = 0;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user, $homeworks, $monitor = false)
    {
        $this->user = $user;
        $this->homeworks = $homeworks;
        $this->monitor = $monitor;
        $this->date = date('Y-m-d');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {        
        return view('components.teacher.homework-tab');
    }
}
