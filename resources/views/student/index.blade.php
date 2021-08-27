@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = []
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card bgVirtuos border-secondary text-light text-center py-5">
                <div class="card-body">
                    <div class="userPortrait-lg mx-auto py-5 mb-2">
                        <i class="fas fa-user fa-3x align-bottom"></i>
                    </div>
                    <h3 class="mb-0">{{ Auth::user()->name }}</h3>
                    <p class="text-white-50">Primaria 2 A</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-secondary px-3">
                <div class="card-body">
                    <table class="table text-center">
                        <thead>
                          <tr>
                            <th class="col-9 text-left"><h5>Materias</h4></th>
                            <th class="col-3"><h5>Status</h4></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-left"><a href="{{ route('studentMateria') }}">Matemáticas</a></td>
                            <td><span class="badge bg-danger tarea-status">Pendiente</span></td>
                          </tr>
                          <tr>
                            <td class="text-left">Español</td>
                            <td><span class="badge bg-info tarea-status">Complete</span></td>
                          </tr>
                          <tr>
                            <td class="text-left">Ciencias</td>
                            <td><span class="badge bg-warning tarea-status">Nueva</span></td>
                          </tr>
                          <tr>
                            <td class="text-left">Artes Plásticas</td>
                            <td><span class="badge bg-danger tarea-status">Pendiente</span></td>
                          </tr>
                          <tr>
                            <td class="text-left">Música</td>
                            <td><span class="badge bg-danger tarea-status">Pendiente</span></td>
                          </tr>
                          <tr>
                            <td class="text-left">Coro</td>
                            <td><span class="badge bg-danger tarea-status">Pendiente</span></td>
                          </tr>
                          <tr>
                            <td class="text-left">Artes Escénicas</td>
                            <td><span class="badge bg-danger tarea-status">Pendiente</span></td>
                          </tr>
                          <tr>
                            <td class="text-left">Deportes</td>
                            <td><span class="badge bg-danger tarea-status">Pendiente</span></td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
