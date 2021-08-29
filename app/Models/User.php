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
        'status',
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

    public function students()
    {
      return $this->belongsToMany(User::class, 'student_tutor', 'student_id');
    }

    public function tutors()
    {
      return $this->belongsToMany(User::class, 'student_tutor', 'tutor_id');
    }

    public function role()
    {
      return $this->belongsTo(Role::class);
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

    public function clases()
    {
        return $this->hasMany(Clase::class);
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
