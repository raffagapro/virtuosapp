<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Clase;
use App\Models\Homework;
use App\Models\StudentHomework;
use App\Models\User;
use Illuminate\Http\Request;
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
        // $homework = Homework::findOrFail($request->homeworkId);
        // $student = User::findOrFail($request->studentId);
        // $foundSH = StudentHomework::where('homework_id', $homework->id)->where('user_id', $student->id)->first();
        // dd($request->all(), StudentHomework::where('homework_id', $homework->id)->where('user_id', $student->id)->first());

        if ($request->hasFile('sFile')) {
            if ($request->file('sFile')->isValid()) {
                $validated = $request->validate([
                    'sFile'=>'mimes:jpeg,png,pdf,doc,ppt,pptx,xlx,xlsx,docx|max:2000',
                ]);
                $homework = Homework::findOrFail($request->homeworkId);
                $workingTitle = str_replace(' ', '_', $homework->title);
                $student = User::findOrFail($request->studentId);
                $workingName = str_replace(' ', '_', $student->name);
                $extension = $request->sFile->extension();
                $saveName = $workingTitle.'_'.$workingName.".".$extension;

                Storage::disk('s3')->put('sHomework/'.$saveName, fopen($request->file('sFile'), 'r+'));
                $url = Storage::disk('s3')->url('sHomework/'.$saveName);

                $foundSH = StudentHomework::where('homework_id', $homework->id)->where('user_id', $student->id)->first();
                if ($foundSH) {
                    $foundSH->media = $url;
                    $foundSH->save();
                } else {
                    $studentHomework = StudentHomework::create([
                        'media' => $url,
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
}
