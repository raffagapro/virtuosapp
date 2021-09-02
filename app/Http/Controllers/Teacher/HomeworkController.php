<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Clase;
use App\Models\Homework;
use App\Models\Retro;
use App\Models\User;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $clase = Clase::findOrFail($id);
        return view('teacher.clase.index')->with(compact('clase'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $homework = Homework::create([
            'title' => $request->titulo,
            'body' => $request->body,
            'vlink' => $request->vlink,
            'student' => (int)$request->studentId,
            'edate' => $request->edate,
        ]);
        $clase = Clase::findOrFail($request->claseId);
        $clase->homeworks()->save($homework);
        $status = 'La tarea ha sido creada exitosamente.';
        return redirect()->route('maestroDash.clase', $clase->id)->with(compact('status'));

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
        return view('teacher.clase.homework.index')->with(compact('homework'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all(), $id);
        $homework = Homework::findOrFail($id);
        $homework->title = $request->modTitulo;
        $homework->body = $request->modBody;
        $homework->vlink = $request->modVlink;
        $homework->student = $request->modStudentId;
        $homework->edate = $request->modEdate;
        $homework->save();
        $status = 'La tarea ha sido actualizada exitosamente.';
        return back()->with(compact('status'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //ADD CODE FOR DELETING CASCADING INFO
        $homework = Homework::findOrFail($id);
        $homework->delete();
        $status = 'La tarea ha sido eliminado exitosamente.';
        return back()->with(compact('status'));

    }

    public function homeworkGrabber(Request $request)
    {
        $homework = Homework::findOrFail($request->homeworkId);
        $students = $homework->clase->students;
        return [$homework, $students];
    }

    public function studentGrabber(Request $request)
    {
        $student = User::findOrFail($request->studentId);
        $homework = Homework::findOrFail($request->homeworkId);
        if ($homework->hasRetro($student->id)) {
            $retro = $homework->hasRetro($student->id);
        } else {
            $retro = 0;
        }
        return [$retro, $student];
    }

    public function newRetro(Request $request)
    {
        // dd($request->all());
        $retro = Retro::create([
            'body' => $request->body
        ]);
        $student = User::findOrFail($request->studentId);
        $student->retros()->save($retro);
        $homework = Homework::findOrFail($request->homeworkId);
        $homework->retros()->save($retro);
        $status = 'La retroalimentacion ha sido guardada exitosamente.';
        return back()->with(compact('status'));
    }

    public function updateRetro(Request $request)
    {
        // dd($request->all());
        $retro = Retro::findOrFail($request->retroId);
        $retro->body = $request->body;
        $retro->save();
 
        $status = 'La retroalimentacion ha sido actualizada exitosamente.';
        return back()->with(compact('status'));
    }
}
