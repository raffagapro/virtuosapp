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

    public function getUser($userId)
    {
        return User::findOrFail($userId);
    }
    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
