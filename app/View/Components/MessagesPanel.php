<?php

namespace App\View\Components;

use App\Models\Chat;
use Illuminate\View\Component;

class MessagesPanel extends Component
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
        $chats = Chat::where('user1', $this->user->id)->orWhere('user2', $this->user->id)->get();
        return view('components.messages-panel')->with(compact('chats'));
    }
}
