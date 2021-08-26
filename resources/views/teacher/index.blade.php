@extends('layouts.app')

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

        <div class="col-md-6">
            <div class="card border-secondary">
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th><h5>Materias</h4></th>
                            <th><h5>Status</h4></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Matemáticas</td>
                            <td><span class="badge bg-danger text-light">Pendiente</span></td>
                          </tr>
                          <tr>
                            <td>Español</td>
                            <td><span class="badge bg-info text-light">Complete</span></td>
                          </tr>
                          <tr>
                            <td>Ciencias</td>
                            <td><span class="badge bg-warning text-light">Nueva</span></td>
                          </tr>
                          <tr>
                            <td>Artes Plásticas</td>
                            <td><span class="badge bg-danger text-light">Pendiente</span></td>
                          </tr>
                          <tr>
                            <td>Música</td>
                            <td><span class="badge bg-danger text-light">Pendiente</span></td>
                          </tr>
                          <tr>
                            <td>Coro</td>
                            <td><span class="badge bg-danger text-light">Pendiente</span></td>
                          </tr>
                          <tr>
                            <td>Artes Escénicas</td>
                            <td><span class="badge bg-danger text-light">Pendiente</span></td>
                          </tr>
                          <tr>
                            <td>Deportes</td>
                            <td><span class="badge bg-danger text-light">Pendiente</span></td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
