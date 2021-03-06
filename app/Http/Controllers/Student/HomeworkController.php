<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Clase;
use App\Models\Homework;
use App\Models\StudentHomework;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeworkController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {
        $clase = Clase::findOrFail($id);
        return view('student.clase.index')->with(compact('clase'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $homework = Homework::findOrFail($id);
        return view('student.clase.homework.index')->with(compact('homework'));
    }

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('hFile')) {
            if ($request->file('hFile')->isValid()) {
                $validated = $request->validate([
                    'hFile'=>'mimes:jpeg,png,pdf,doc,ppt,pptx,xlx,xlsx,docx,zip|max:4000',
                ]);
                $homework = Homework::findOrFail($request->homeworkId);
                $workingTitle = str_replace(' ', '_', $homework->title);
                $student = User::findOrFail($request->studentId);
                $workingName = str_replace(' ', '_', $student->name);
                $extension = $request->hFile->extension();
                $saveName = $workingTitle.'_'.$workingName.".".$extension;

                Storage::disk('s3')->put('sHomework/'.$saveName, fopen($request->file('hFile'), 'r+'));
                $url = Storage::disk('s3')->url('sHomework/'.$saveName);

                $foundSH = StudentHomework::where('homework_id', $homework->id)->where('user_id', $student->id)->first();
                if ($foundSH) {
                    $foundSH->media = $url;
                    $foundSH->save();
                } else {
                    $studentHomework = StudentHomework::create([
                        'media' => $url,
                        'status' => 1,
                    ]);
                    $homework->studentHomeworks()->save($studentHomework);
                    $student->studentHomeworks()->save($studentHomework);
                }
            }
            $eStatus = 1;
            $status = 'La tarea ha sido guardada exitosamente.';
        }else{
            $eStatus = 0;
            $status = 'No se adjunto archivo a la tarea.';
        }
        return back()->with(compact('status', 'eStatus'));
    }

    public function markComplete($homeworkId, $studentId)
    {
        $foundSH = StudentHomework::where('homework_id', $homeworkId)->where('user_id', $studentId)->first();
        if ($foundSH) {
            $foundSH->status = 1;
            $foundSH->save();
        } else {
            $studentHomework = StudentHomework::create([
                'status' => 1,
            ]);
            $homework = Homework::findOrFail($homeworkId);
            $homework->studentHomeworks()->save($studentHomework);
    
            $student = User::findOrFail($studentId);
            $student->studentHomeworks()->save($studentHomework);  
        }
        $status = 'La tarea ha sido marcada como completada.';
        return back()->with(compact('status'));
    }
}
