<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'curp',
        'edad',
        'tutor1',
        'tutor2',
        'status',
        'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
      return $this->belongsTo(Role::class);
    }

    public function getTutor($tutorID)
    {
      return User::findOrFail($tutorID);
    }

    public function area()
    {
      return $this->belongsTo(Area::class);
    }

    public function modalidad()
    {
      return $this->belongsTo(Modalidad::class);
    }

    public function grado()
    {
      return $this->belongsTo(Grado::class);
    }

    public function retros()
    {
        return $this->hasMany(Retro::class);
    }

    public function studentHomeworks()
    {
        return $this->hasMany(StudentHomework::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function clases()
    {
        return $this->belongsToMany(Clase::class);
    }

    public function coordinators()
    {
        return Coordinator::where('coordinator', $this->id)->get();
    }

    public function hasClase($clase)
    {
      if ($this->clases()->where('clase_id', $clase->id)->first()) {
        return true;
      }
      return false;
    }

    public function getNameAttribute($name)
    {
      return ucwords($name);
    }
    public function setNameAttribute($name)
    {
      $this->attributes['name'] = mb_strtolower($name);
    }
}
