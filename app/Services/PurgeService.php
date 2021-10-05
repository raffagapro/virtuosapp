<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\Clase;
use App\Models\Coordinator;
use App\Models\Homework;
use App\Models\Retro;
use App\Models\StudentHomework;
use App\Models\User;

class PurgeService
{
    public function purge($user){
        $chats = Chat::where('user1', $user->id)->orWhere('user2', $user->id)->get();
        foreach ($chats as $c) {
            foreach ($c->chatMessages() as $key => $cm) {
                $cm->delete();
            }
            $c->delete();
        }
        $homeworks = Homework::where('student', $user->id);
        foreach ($homeworks as $h) {
            foreach ($h->studentHomeworks() as $key => $sh) {
                $sh->delete();
            }
            foreach ($h->retros() as $key => $r) {
                $r->delete();
            }
            $h->delete();
        }
        $studentHomeworks = StudentHomework::where('user_id', $user->id);
        foreach ($studentHomeworks as $ssh) {
            $ssh->delete();
        }
        $studentRetros = Retro::where('user_id', $user->id);
        foreach ($studentRetros as $sr) {
            $sr->delete();
        }
        foreach ($user->clases() as $cl) {
            $user->clases()->detach($cl);
        }
        $teacherClases = Clase::where('teacher', $user->id);
        foreach ($teacherClases as $tcl) {
            $tcl->teacher = 0;
        }
        $coords = Coordinator::where('teacher', $user->id)->orWhere('coordinator', $user->id);
        foreach ($coords as $cdr) {
            $cdr->delete();
        }
        $children = User::where('tutor1', $user->id)->orWhere('tutor2', $user->id);
        foreach ($children as $chld) {
            if ($chld->tutor1 === $user->id) {
                $chld->tutor1 = null;
            } else {
                $chld->tutor2 = null;
            }
            
        }
        return true;
    }
}