<?php

namespace App\View\Components;

use App\Models\Chat;
use App\Models\User;
use Illuminate\View\Component;

class ChatModal extends Component
{
    public $user;
    public $monitor;
    public $chat;
    public $recieverUser;
    public $finalDate;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user, $monitor = false, $recieverUser = null, $chat = null)
    {
        $this->user = $user;
        $this->monitor = $monitor;
        $this->recieverUser = $recieverUser;
        $this->chat = $chat;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if (session('chatGo')) {
            $this->chat = Chat::findOrFail(session('chatGo'));
            if ($this->user->id === $this->chat->user1) {
                $this->recieverUser = User::findOrFail($this->chat->user2);
            } else {
                $this->recieverUser = User::findOrFail($this->chat->user1);
            }
        }
        return view('components.chat-modal');
    }
}
