<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'body',
        'status'
    ];
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function dateParser()
    {
        $date = Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:s:i'));
        $mdate = Carbon::createFromFormat('Y-m-d H:s:i', $this->created_at);
        $days = $date->diffInDays($mdate);
        $timez = explode(" ", $this->created_at);
        $timez = $timez[1];
        $timez = substr($timez, 0, -3);
        $timex = explode(":", $timez);
        if ($timex[0] >= 12) {
            $timez  = $timez . 'pm';
        } else {
            $timez  = $timez . 'am';
        }
        if ($days > 0) {
            if ($days == 1) {
                $finalDateText = "Ayer - " . $timez;
            } elseif ($days == 7) {
                $finalDateText = "1 Semana - " . $timez;
            } elseif ($days > 7) {
                $finalDateText = floor($days/7) . ' semanas - ' . $timez;
            } else {
                $finalDateText = $days . " días - " . $timez;
            }
        } else {
            $finalDateText = "Hoy - " . $timez;
        }
        
        return $finalDateText;
    }
}
