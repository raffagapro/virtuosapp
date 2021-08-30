@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Materias"=>'materias']
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-secondary text-center">
        <div class="card-body">
          <h3>Matemáticas 101</h3>
          <div class="row mb-3">
            <div class="col-6 ml-auto">
              <p class="text-secondary">Docente  Estefania Lopez</p>
            </div>
            <div class="col-3">
              <button class="btn btn-primary" data-toggle="modal" data-target="#addClassModal"><i class="fas fa-pen"></i></button>
              <button class="btn btn-primary" data-toggle="modal" data-target="#addClassModal"><i class="fas fa-book-reader"></i></button>
            </div>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="col-9 text-left"><h5>Alumnos</h5></th>
                <th class="col-3"><h5>Eliminar</h5></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                {{-- CHANGE ROTE TO CLASS EDIT PAGE!!!!  --}}
                <td class="text-left"><a href="">Raul Perez</a></td>
                <td>
                  <span class="btn btn-sm btn-danger text-white mr-2 classBtnModal"><i class="far fa-trash-alt"></i></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection