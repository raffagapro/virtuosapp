<?php

namespace App\View\Components\Homework;

use Illuminate\View\Component;

class TeacherFilesPanel extends Component
{
    public $user;
    public $homework;
    public $monitor;
    public $tempRoute;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user, $homework, $monitor = false)
    {
        $this->user = $user;
        $this->homework = $homework;
        $this->monitor = $monitor;
        if (!$monitor) {
            $this->tempRoute = "maestroDash.dfile";
        } else {
            if ($user->role->name === "Coordinador") {
                $this->tempRoute = "monitor.dfile";
            } else {
                $this->tempRoute = "admin.monitorTeacherDfile";
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.homework.teacher-files-panel');
    }
}
