<?php

namespace App\View\Components\Homework;

use Illuminate\View\Component;

class StudentPanel extends Component
{
    public $homework;
    public $monitor;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($homework, $monitor = false)
    {
        $this->homework = $homework;
        $this->monitor = $monitor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->homework->student > 0) {
            $students = [$this->homework->getStudent()];
        } else {
            $students = $this->homework->clase->students;
        }
        return view('components.homework.student-panel')->with(compact('students'));
    }
}
