<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'media',
    ];

    public function homework()
    {
        return $this->belongsTo(Homework::class);
    }
}
