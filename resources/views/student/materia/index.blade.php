@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Materia"=>'studentMateria']
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-secondary text-center">
                <div class="card-body px-0">
                    <div class="my-3">
                        <h3>Matemáticas / 6to Primaria</h3>
                    </div>
                    <div class="py-3">
                        <table class="table">
                            <thead>
                                <tr class="border-top">
                                    <th class="col-6 text-left  border-right pl-5"><h5>Tareas</h4></th>
                                    <th class="border-right"><h5>Fecha de entrega</h4></th>
                                    <th class="pr-4"><h5>Status</h4></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left border-right pl-5"><a href="{{ route('tarea') }}">tarea</a></td>
                                    <td class="border-right">Pendiente</td>
                                    <td class="pr-4"><span class="badge bg-info tarea-status">Complete</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left border-right pl-5">Pendiente</td>
                                    <td class="border-right">Pendiente</td>
                                    <td class="pr-4"><span class="badge bg-warning tarea-status">Nueva</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left border-right pl-5">Pendiente</td>
                                    <td class="border-right">Pendiente</td>
                                    <td class="pr-4"><span class="badge bg-danger tarea-status">Pendiente</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left border-right pl-5">Pendiente</td>
                                    <td class="border-right">Pendiente</td>
                                    <td class="pr-4"><span class="badge bg-danger tarea-status">Pendiente</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left border-right pl-5">Pendiente</td>
                                    <td class="border-right">Pendiente</td>
                                    <td class="pr-4"><span class="badge bg-danger tarea-status">Pendiente</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left border-right pl-5">Pendiente</td>
                                    <td class="border-right">Pendiente</td>
                                    <td class="pr-4"><span class="badge bg-danger tarea-status">Pendiente</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left border-right pl-5">Pendiente</td>
                                    <td class="border-right">Pendiente</td>
                                    <td class="pr-4"><span class="badge bg-danger tarea-status">Pendiente</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left border-right pl-5">Pendiente</td>
                                    <td class="border-right">Pendiente</td>
                                    <td class="pr-4"><span class="badge bg-danger tarea-status">Pendiente</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bgVirtuos-docente border-secondary text-center py-5">
                <div class="card-body">
                    <div class="userPortrait-lg mx-auto py-5 mb-2">
                        <i class="fas fa-user fa-3x align-bottom"></i>
                    </div>
                    <h3 class="mb-0">{{ Auth::user()->name }}</h3>
                    <p class="text-secondary">Docente</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="materiasModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection
