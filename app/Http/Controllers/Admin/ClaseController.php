<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clase;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class ClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $materia = Materia::findOrFail($id);
        // dd($materia);
        return view('admin.materias.clase.index')->with(compact('materia'));
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
        $clase = Clase::create([
            'label' => $request->label,
            'sdate' => $request->sdate,
            'edate' => $request->edate,
            'teacher' => 0,
            'status' => 1,
        ]);
        if ($request->teacherId != 0) {
            $clase->teacher = $request->teacherId;
        }
        $clase->save();
        $materia = Materia::findOrFail((int)$request->materiaId);
        $materia->clases()->save($clase);
        $status = 'La clase ha sido creada exitosamente.';
        return redirect()->route('clase.index', $materia->id)->with(compact('status'));
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
        //NEEDS CODING TO DIRECT TO THE CLASS PAGE, NOT MATERIA PAGE
        // $materia = Materia::findOrFail($id);
        // return view('test.edit')->with(compact('materia'));
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
        $materia = Materia::findOrFail((int)$request->materiaId);
        $clase = Clase::findOrFail($id);
        $clase->label = $request->modLabel;
        $clase->sdate = $request->modSdate;
        $clase->edate = $request->modEdate;
        $clase->teacher = $request->modteacherId;
        $clase->save();
        $status = 'La clase ha sido actualizada exitosamente.';
        return redirect()->route('clase.index', $materia->id)->with(compact('status'));
    }

    public function activate($id)
    {
        $clase = Clase::findOrFail($id);
        $materia = Materia::findOrFail($clase->materia->id);
        // dd($materia->id);
        $clase->status = 1;
        $clase->save();
        $status = 'La clase ha sido activada exitosamente.';
        return redirect()->route('clase.index', $materia->id)->with(compact('status'));
    }

    public function deactivate($id)
    {
        $clase = Clase::findOrFail($id);
        $materia = Materia::findOrFail($clase->materia->id);
        // dd($materia->id);
        $clase->status = 0;
        $clase->save();
        $status = 'La clase ha sido desactivada exitosamente.';
        return redirect()->route('clase.index', $materia->id)->with(compact('status'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //POSIBLEMENTE AGREGAR MAS CODGO PARA BORRAR TODO LO RELACIONADO CON LA CLASE
        $clase = Clase::findOrFail($id);
        $materia = Materia::findOrFail($clase->materia->id);
        $clase->delete();
        $status = 'La clase ha sido eliminada exitosamente.';
        return redirect()->route('clase.index', $materia->id)->with(compact('status'));
    }

    public function claseGrabber(Request $request){
        $clase = Clase::findOrFail($request->claseId);
        $teachers = User::whereHas(
            'role', function($q){
                $q->where('name', 'maestro');
            }
        )->get();
        return [$clase, $teachers];
    }
}