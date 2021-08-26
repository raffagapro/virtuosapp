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
        'status'
    ];

    public function teacher()
    {
        return User::where('id', $this->teacher);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class);
    }
}
