<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    use HasFactory;
    protected $fillable = [
        'coordinator',
        'teacher'
    ];
    public function getCoordinator(){
        return User::findOrFail($this->coordinator);
    }
    public function getTeacher(){
        return User::findOrFail($this->teacher);
    }
}
