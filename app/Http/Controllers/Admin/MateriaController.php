<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $materias = Materia::paginate(50);
        return view('admin.materias.index')->with(compact('materias'));
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
        ]);

        $materia = Materia::create([
            'name' => $request->nombre,
        ]);
        $status = 'La materia ha sido creada exitosamente.';
        return redirect()->route('materias.index')->with(compact('status'));
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
        $materia = Materia::findOrFail($id);
        return view('test.edit')->with(compact('materia'));
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
            'modNombre' => 'required|max:255',
        ]);

        $materia = Materia::findOrFail($id);
        $materia->name = $request->modNombre;
        $materia->save();
        $status = 'La materia ha sido actualizada exitosamente.';
        return redirect()->route('materias.index')->with(compact('status'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $materia = Materia::findOrFail($id);
        $materia->delete();
        $status = 'La materia ha sido eliminada exitosamente.';
        return redirect()->route('materias.index')->with(compact('status'));
    }

    public function materiaGrabber(Request $request){
        $materia = Materia::findOrFail($request->materiaId);
        return $materia;
    }
}
