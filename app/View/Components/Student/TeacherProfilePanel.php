<?php

namespace App\View\Components\Student;

use App\Models\Chat;
use Illuminate\View\Component;

class TeacherProfilePanel extends Component
{
    public $clase;
    public $user;
    public $monitor;
    public $unreadMessages = 0;
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
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $clasef = $this->clase;
        $foundChat = Chat::where('user1', $this->user->id)->where(function ($q) use ($clasef){
            $q->where('user2', $clasef->teacher()->id);
        })
        ->orWhere('user2', $this->user->id)->where(function ($q) use ($clasef){
            $q->where('user1', $clasef->teacher()->id);
        })
        ->first();
        if (!$foundChat) {
            $foundChat = Chat::create([
                'user1' => $this->user->id,
                'user2' => $this->clase->teacher()->id,
            ]);
        }
        foreach ($foundChat->chatMessages as $cmw) {
            if ($cmw->user_id !== $this->user->id && $cmw->status === 0) {
                $this->unreadMessages++;
            }
        }
        return view('components.student.teacher-profile-panel')->with(compact('foundChat'));
    }
}
