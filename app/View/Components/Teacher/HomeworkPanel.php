<?php

namespace App\View\Components\Teacher;

use Illuminate\View\Component;

class HomeworkPanel extends Component
{
    public $user;
    public $clase;
    public $monitor;
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
        $activas = $this->clase->homeworks->where('edate', '>=', $this->date)->sortBy('edate');
        $cerradas = $this->clase->homeworks->where('edate', '<', $this->date)->sortBy('edate', SORT_REGULAR, true);
        return view('components.teacher.homework-panel')->with(compact('activas', 'cerradas'));
    }
}
