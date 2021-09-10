<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'user1',
        'user2'
    ];

    public function getUser1()
    {
        return User::findOrFail($this->user1);
    }
    public function getUser2()
    {
        return User::findOrFail($this->user2);
    }
    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
