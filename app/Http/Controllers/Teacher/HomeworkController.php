<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Clase;
use App\Models\Homework;
use App\Models\Media;
use App\Models\Retro;
use App\Models\StudentHomework;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'titulo' => 'required',
            'body' => 'required',
        ]);

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
        $request->validate([
            'modTitulo' => 'required',
            'modBody' => 'required',
        ]);

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
        $foundSH = StudentHomework::where('homework_id', $homework->id)->where('user_id', $student->id)->first();
        if ($foundSH) {
            $foundSH->status = 2;
            $foundSH->save();
        } else {
            $studentHomework = StudentHomework::create([
                'status' => 2,
            ]);
            $homework->studentHomeworks()->save($studentHomework);
            $student->studentHomeworks()->save($studentHomework);  
        }
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

    public function uploadFile(Request $request)
    {   
        $homework = Homework::findOrFail($request->homeworkId);
        if ($request->hasFile('hFile')) {
            if ($request->file('hFile')->isValid()) {
                $validated = $request->validate([
                    'hFile'=>'mimes:jpeg,png,pdf,doc,ppt,pptx,xlx,xlsx,docx|max:2000',
                ]);
                $homework = Homework::findOrFail($request->homeworkId);
                $workingTitle = str_replace(' ', '_', $homework->title);
                $originalName = substr($request->hFile->getClientOriginalName(), 0, strrpos($request->hFile->getClientOriginalName(), "."));
                $originalName = str_replace(' ', '_', $originalName);
                $extension = $request->hFile->extension();
                $saveName = $workingTitle.'_'.$originalName.".".$extension;
                // dd($saveName, $request->file('hFile'));

                Storage::disk('s3')->put('tHomework/'.$saveName, fopen($request->file('hFile'), 'r+'));
                $url = Storage::disk('s3')->url('tHomework/'.$saveName);

                // $request->hFile->storeAs('/public/tHomework', $workingTitle.'_'.$originalName.".".$extension);
                // $url = Storage::url('tHomework/'.$workingTitle.'_'.$originalName.".".$extension);

                $media = Media::create([
                    'media' => $url,
                ]);
                $homework->medias()->save($media);
            }
            $eStatus = 1;
            $status = 'El archivo ha sido guardado exitosamente.';
        }else{
            $eStatus = 0;
            $status = 'No se adjunto archivo a la tarea.';
        }
        return back()->with(compact('status', 'eStatus'));
    }

    public function uploadProfile(Request $request)
    {
        $user = User::findOrFail($request->userId);
        if ($request->hasFile('photoFile')) {
            if ($request->file('photoFile')->isValid()) {
                $validated = $request->validate([
                    'photoFile'=>'mimes:jpeg,png|max:2000',
                ]);
 
                $extension = $request->photoFile->extension();
                $saveName = 'perfil_'.$user->id.'.'.$extension;
                // dd($saveName, $request->file('hFile'));

                Storage::disk('s3')->put('perfil/'.$saveName, fopen($request->file('photoFile'), 'r+'));
                $url = Storage::disk('s3')->url('perfil/'.$saveName);

                $user->perfil = $url;
                $user->save();
            }
            $eStatus = 1;
            $status = 'El perfil ha sido guardado exitosamente.';
        }else{
            $eStatus = 0;
            $status = 'No se gurado el perfil.';
        }
        return back()->with(compact('status', 'eStatus'));
    }

    public function deleteFile($fileId)
    {
        $foundMedia = Media::findOrFail($fileId);
        // $delMedia = str_replace('/storage/', "",$foundMedia->media);
        Storage::disk('s3')->delete(parse_url($foundMedia->media));
        $foundMedia->delete();
        $status = 'El archivo se ha eliminado exitosamente.';
        return back()->with(compact('status'));
    }
}
