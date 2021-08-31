@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Clase"=>'maestroCourse']
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-secondary text-center">
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-4">

            </div>
            <h3 class="col-4">Materias</h3>
            <div class="col-4">
              <button class="btn btn-primary float-right" data-toggle="modal" data-target="#materiasModal">Agregar<i class="fas fa-book-reader ml-2"></i></button>
            </div>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="col-4 text-left"><h5>Nombre</h5></th>
                <th><h5>Fecha de creación</h5></th>
                <th><h5>Fecha de entrega</h5></th>
                <th><h5>Asignado</h5></th>
                <th><h5>Actualizar</h5></th>
              </tr>
            </thead>  
            <tbody>
              <tr>
                <td class="text-left"><a href="{{ route('maestroTest') }}">clase1</a></td>
                <td></td>
                <td></td>
                <td>
                  <span class="badge bg-info tarea-status">Complete</span>
                </td>
                <td>
                  <span class="btn btn-sm btn-primary text-white mr-2 materiaBtn" data-toggle="tooltip" data-placement="top" title="Modificar" id=""><i class="fas fa-pen" data-toggle="modal" data-target="#materiasModModal"></i></span>
                  <span class="btn btn-sm btn-danger text-white mr-2 materiaBtn"><i class="far fa-trash-alt"></i></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar Materia -->
<div class="modal fade" id="materiasModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nueva Materia</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        


      </div>
    </div>
  </div>
</div>

<!-- Modal Modificar Materia -->
<div class="modal fade" id="materiasModModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modificar Materia</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        


      </div>
    </div>
  </div>
</div>

@endsection