<?php

namespace App\View\Components\Homework;

use App\Models\Retro;
use Illuminate\View\Component;

class RetroPanel extends Component
{
    public $user;
    public $homework;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user, $homework)
    {
        $this->user = $user;
        $this->homework = $homework;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $retro = Retro::where('homework_id', $this->homework->id)->where('user_id', $this->user->id)->first();
        return view('components.homework.retro-panel')->with(compact('retro'));
    }
}
