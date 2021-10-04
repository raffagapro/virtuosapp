<?php

namespace App\View\Components\Student;

use Illuminate\View\Component;

class HomeworkPanel extends Component
{
    public $clase;
    public $user;
    public $monitor;
    public $homeworkCounter = 0;
    public $date;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user, $clase, $monitor = false)
    {
        $this->user = $user;
        $this->clase = $clase;
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
        return view('components.student.homework-panel');
    }
}
