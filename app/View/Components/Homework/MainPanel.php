<?php

namespace App\View\Components\Homework;

use App\Models\StudentHomework;
use Illuminate\View\Component;

class MainPanel extends Component
{
    public $user;
    public $homework;
    public $monitor;
    public $studentHomework;
    public $markCompleteBtnGo = false;
    public $uploadFileBtnGo = false;
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
        if ($user->role->name == "Estudiante") {
            $this->studentHomework = StudentHomework::where('homework_id', $homework->id)->where('user_id', $user->id)->first();
        }

        if (!$this->studentHomework) {
            $this->markCompleteBtnGo = true;
        }else {
            if ($this->studentHomework->status < 1) {
                $this->markCompleteBtnGo = true;
            }
            if ($this->studentHomework->media !== null) {
                $this->uploadFileBtnGo = true;
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
        return view('components.homework.main-panel');
    }
}
