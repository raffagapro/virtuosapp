<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Role;
use App\Models\Area;
use App\Models\Clase;
use App\Http\Controllers\Controller;
use App\Services\PurgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class TutorListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tutors = User::whereHas(
            'role', function($q){
                $q->where('name', 'tutor');
            }
        )->orderBy('name')->paginate(50);
        return view('admin.tutorList.index')->with(compact('tutors'));
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
            'nombre' => 'required|max:255',
            'username' => 'required|unique:users|max:255',
            'email' => 'required|max:255',
            'curp' => 'required|max:255',
        ]);

        $workingPW = explode(' ', strtolower($request->nombre));
        $pw = 'VI'.ucfirst($workingPW[0]).'2022';
        // dd($pw, $request->all(), strtolower($request->nombre));
        $tutor = User::create([
            'name' => $request->nombre,
            'username' => $request->username,
            'email' => $request->email,
            'curp' => $request->curp,
            'status' => 1,
            'password' => Hash::make($pw),
        ]);

        $role = Role::where('name', 'tutor')->first();
        $role->user()->save($tutor);

        $status = 'El tutor ha sido creado exitosamente.';
        return redirect()->route('tutores.index')->with(compact('status'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tutor = User::findOrFail($id);
        return view('admin.tutorList.details')->with(compact('tutor'));
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
        $tutor = User::findOrFail($id);
        if ($tutor->username === $request->modUserName) {
            $request->validate([
                'modNombre' => 'required|max:255',
                'modUserName' => 'required|max:255',
                'modEmail' => 'required|max:255',
                'modCurp' => 'required|max:255',
            ]);
        } else {
            $request->validate([
                'modNombre' => 'required|max:255',
                'modUserName' => 'required|unique:users,username|max:255',
                'modEmail' => 'required|max:255',
                'modCurp' => 'required|max:255',
            ]);
        }

        $tutor->name = $request->modNombre;
        $tutor->username = $request->modUserName;
        $tutor->email = $request->modEmail;
        $tutor->curp = $request->modCurp;

        $tutor->save();
        $status = 'El tutor ha sido actualizado exitosamente.';
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
        // EXPANDER EN EL FUTURO PARA INCLUIR RELATED DB INFO
        $tutor = User::findOrFail($id);
        $purge = new PurgeService();
        $purge->purge($tutor);
        $tutor->delete();
        $status = 'El tutor ha sido eliminado exitosamente.';
        return redirect()->route('tutores.index')->with(compact('status'));
    }

    public function addtutor($classID, $tutorID){
        $clase = Clase::findOrFail($classID);
        $tutor = User::findOrFail($tutorID);
        // dd($clase, $student);
        $clase->tutor = $tutor->id;
        $clase->save();
        $status = 'La clase ha sido agregada exitosamente.';
        return back()->with(compact('status'));
    }

    public function rmtutor($classID, $tutorID){
        $clase = Clase::findOrFail($classID);
        // dd($clase);
        $clase->tutor = 0;
        $clase->save();
        $status = 'La clase ha sido eliminada exitosamente.';
        return back()->with(compact('status'));
    }

    public function addStudent($tutorID, $studentID){
        // $tutor = User::findOrFail($tutorID);
        // $student = User::findOrFail($studentID);
        // // dd($clase, $student);
        // if (!$student->hasClase($clase)) {
        //     $student->clases()->attach($clase);
        // }
        // $status = 'El estudiante ha sido agregado exitosamente.';
        // return back()->with(compact('status'));
    }

    public function rmStudent($tutorID, $studentID){
        // $clase = Clase::findOrFail($tutorID);
        // $student = User::findOrFail($studentID);
        // // dd($clase, $student);
        // $student->clases()->detach($clase);
        // $status = 'El estudiante ha sido eliminado exitosamente.';
        // return back()->with(compact('status'));
    }
}
