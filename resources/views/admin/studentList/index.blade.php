@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Estudiantes"=>'studentList']
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
                    <h3 class="col-4">Estudiantes</h3>
                    <div class="col-4">
                      <button class="btn btn-primary">Agregar<i class="fas fa-book-reader ml-2"></i></button>
                    </div>
                  </div>
                  <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="col-6 text-start"><h5>Nombre</h4></th>
                          <th><h5>Grado</h4></th>
                          <th><h5>Actualizar</h4></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="text-start">Pendiente</td>
                          <td>Pendiente</td>
                          <td><span class="btn btn-primary text-light mr-2"><i class="fas fa-pen"></i></span><span class="btn btn-danger text-light"><i class="far fa-trash-alt"></i></span></td>
                        </tr>
                        <tr>
                          <td class="text-start">Pendiente</td>
                          <td>Pendiente</td>
                        </tr>
                        <tr>
                          <td class="text-start">Pendiente</td>
                          <td>Pendiente</td>
                        </tr>
                        <tr>
                          <td class="text-start">Pendiente</td>
                          <td>Pendiente</td>
                        </tr>
                        <tr>
                          <td class="text-start">Pendiente</td>
                          <td>Pendiente</td>
                        </tr>
                        <tr>
                          <td class="text-start">Pendiente</td>
                          <td>Pendiente</td>
                        </tr>
                        <tr>
                          <td class="text-start">Pendiente</td>
                          <td>Pendiente</td>
                        </tr>
                        <tr>
                          <td class="text-start">Pendiente</td>
                          <td>Pendiente</td>
                        </tr>
                      </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
