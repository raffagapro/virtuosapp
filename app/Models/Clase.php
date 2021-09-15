<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'sdate',
        'edate',
        'teacher',
        'status',
        'zlink',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function homeworks()
    {
        return $this->hasMany(Homework::class);
    }
    public function students()
    {
        return $this->belongsToMany(User::class);
    }
    public function teacher()
    {
        return User::findOrFail($this->teacher);
    }

    public function getLabelAttribute($label)
    {
      return ucwords($label);
    }
    public function setLabelAttribute($label)
    {
      $this->attributes['label'] = mb_strtolower($label);
    }
}
