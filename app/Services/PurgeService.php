<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\Clase;
use App\Models\Coordinator;
use App\Models\Homework;
use App\Models\Media;
use App\Models\Retro;
use App\Models\StudentHomework;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PurgeService
{
    public function purge($user){
        Storage::disk('s3')->delete(parse_url($user->perfil));
        $chats = Chat::where('user1', $user->id)->orWhere('user2', $user->id)->get();
        foreach ($chats as $c) {
            foreach ($c->chatMessages() as $key => $cm) {
                $cm->delete();
            }
            $c->delete();
        }
        $homeworks = Homework::where('student', $user->id);
        foreach ($homeworks as $h) {
            $this->purgeIndvHomework($h);
        }
        $studentHomeworks = StudentHomework::where('user_id', $user->id);
        foreach ($studentHomeworks as $ssh) {
            Storage::disk('s3')->delete(parse_url($ssh->media));
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

    public function purgeStudentClass($student, $class){
        // GET HOMEWORKS FOR THE ERASED STUDENT
        $homeworks = Homework::where('clase_id', $class->id)->where('student', $student->id)->get();
        foreach ($homeworks as $hw) {
            $this->purgeIndvHomework($hw);
        }
    }

    public function purgeIndvHomework($hw){
        // TEACHER HOMEWORK FILES
        foreach ($hw->medias as $m) {
            Storage::disk('s3')->delete(parse_url($m->media));
            $m->delete();
        }
        //STUDENT HOMEWORK OBJS
        $studentHomeworks = StudentHomework::where('homework_id', $hw->id)->get();
        foreach ($studentHomeworks as $shw) {
            Storage::disk('s3')->delete(parse_url($shw->media));
            $shw->delete();
        }
        //RETRO
        $retro = Retro::where('homework_id', $hw->id);
        foreach ($retro as $r) {
            $r->delete();
        }
        // DELETES FOUND HOMEWORK
        $hw->delete();
    }
}