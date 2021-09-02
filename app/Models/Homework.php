<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'vlink',
        'student',
        'edate',
    ];

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }

    public function studentHomeworks()
    {
        return $this->hasMany(StudentHomework::class);
    }

    public function retros()
    {
        return $this->hasMany(Retro::class);
    }

    public function medias()
    {
        return $this->hasMany(Media::class);
    }

    public function hasRetro($studentId)
    {
        if (Retro::where('homework_id', $this->id)->where('user_id', $studentId)->first()) {
            return Retro::where('homework_id', $this->id)->where('user_id', $studentId)->first();
        } else {
            return false;
        }
    }

    public function getStudent()
    {
        return User::findOrFail($this->student);
    }

    public function getTitleAttribute($title)
    {
      return ucwords($title);
    }
    public function setTitleAttribute($title)
    {
      $this->attributes['title'] = mb_strtolower($title);
    }
}
