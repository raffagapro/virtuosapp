<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $foundChat = Chat::where('user1', Auth::user()->id)->where(function ($q) use ($id){
            $q->where('user2', $id);
        })
        ->orWhere('user2', Auth::user()->id)->where(function ($q) use ($id){
            $q->where('user1', $id);
        })
        ->first();
        if (!$foundChat) {
            $foundChat = Chat::create([
                'user1' => Auth::user()->id,
                'user2' => $id,
            ]);
        }
        $chatGo = $foundChat->id;
        $reciver = $id;
        return back()->with(compact('foundChat', 'chatGo', 'reciver'));

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $foundChat = Chat::findOrFail($request->chatId);
        $sender = User::findOrFail($request->senderId);
        if ($request->messageBody !== null) {
            $chatMessage = ChatMessage::create([
                'body' => $request->messageBody,
                'status' => 0,
            ]);
            $sender->chatMessages()->save($chatMessage);
            $foundChat->chatMessages()->save($chatMessage);
        }
        $chatGo = $foundChat->id;
        if ($foundChat->user1 === $sender->id) {
            $reciver = $foundChat->user2;
        } else {
            $reciver = $foundChat->user1;
        }
        return back()->with(compact('chatGo', 'reciver'));
    }

    public function grabber(Request $request)
    {
        $foundChat = Chat::findOrFail($request->chatId);
        $reciever = User::findOrFail($request->recieverId);
        $messages = $foundChat->chatMessages;
        $role = Role::where('name', 'coordinador')->first();
        if (Auth::user()->role->id !== $role->id) {
            foreach ($messages as $m) {
                if ($m->user->id !== Auth::user()->id) {
                    $m->status = 1;
                    $m->save();
                }
            }
        }
        return [$messages, $reciever, $foundChat->id];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $foundChat = Chat::findOrFail($request->chatId);
        foreach ($foundChat->chatMessages as $cmw) {
            if ($cmw->user_id !== Auth::user()->id && $cmw->status === 0) {
                $cmw->status = 1;
                $cmw->save();
            }
        }
        return $foundChat;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
