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
                      <button class="btn btn-primary float-right" data-toggle="modal" data-target="#newStudentModal">Agregar<i class="fas fa-book-reader ml-2"></i></button>
                    </div>
                  </div>
                  <table class="table table-bordered">
                    @if (count($students) > 0)
                      <thead>
                        <tr>
                          <th class="col-6 text-start"><h5>Nombre</h4></th>
                          <th><h5>Grado</h4></th>
                          <th><h5>Actualizar</h4></th>
                        </tr>
                      </thead> 
                    @endif
                    <tbody>
                      @forelse ($students as $s)
                        <tr>
                          {{-- NOMBRE --}}
                          <td><a href="{{ route('estudiantes.edit', $s->id) }}">{{ ucwords($s->name) }}</a></td>
                          {{-- GRADO --}}
                          @if (isset($s->grado))
                            <td>{{ $s->grado->name }}</td>
                          @else
                              <td>-</td>
                          @endif
                          {{-- ACTUALIZAR --}}
                          <td>
                            <a
                                href="{{ route('admin.studentMonitor', $s->id) }}" class="btn btn-sm btn-primary text-light mr-2"
                                data-toggle="tooltip" data-placement="top" title="Monitorear">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if ($s->status === 0)
                              <a
                                href="javascript:void(0);"
                                class="btn btn-sm btn-success text-light mr-2"
                                data-toggle="tooltip" data-placement="top" title="Activar"
                                onclick="event.preventDefault(); document.getElementById('{{ 'studentActivate'.$s->id }}').submit();">
                                <i class="fas fa-check"></i>
                              </a>
                              <form id="{{ 'studentActivate'.$s->id }}"
                                action="{{ route('estudiantes.activate', $s->id) }}"
                                method="POST"
                                style="display: none;"
                                >@method('PUT') @csrf
                              </form>
                            @else
                              <a
                                href="javascript:void(0);"
                                class="btn btn-sm btn-danger text-light mr-2"
                                data-toggle="tooltip" data-placement="top" title="Desactivar"
                                onclick="event.preventDefault(); document.getElementById('{{ 'studentDeactivate'.$s->id }}').submit();">
                                <i class="fas fa-times"></i>
                              </a>
                              <form id="{{ 'studentDeactivate'.$s->id }}"
                                action="{{ route('estudiantes.deactivate', $s->id) }}"
                                method="POST"
                                style="display: none;"
                                >@method('PUT') @csrf
                              </form>
                            @endif
                            <x-delete-btn
                                    :tooltip="'Borrar'"
                                    :id="[$s->id]"
                                    :text="'¿Deseas eliminar el estudiante?'"
                                    :elemName="'delStudent'"
                                    :routeName="'estudiantes.destroy'"
                            />
                          </td>
                        </tr>
                      @empty
                        <div class="alert alert-danger" role="alert">
                          Sin estudiantes
                        </div>
                      @endforelse
                    </tbody>
                  </table>
                  {{-- Paginator --}}
                  {{$students->links()}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Student -->
<div class="modal fade" id="newStudentModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Estudiante</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('estudiantes.store') }}" method="POST">
          @csrf
          {{--  NOMBRE  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" placeholder="Nombre">
            @error('nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            
          </div>
          {{--  USUARIO  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Usuario">
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  Email  --}}
          <div class="form-group">
            <input type="mail" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Correo">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  CURP  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('curp') is-invalid @enderror" name="curp" placeholder="CURP">
            @error('curp')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{-- EDAD / GRADO --}}
          <div class="form-group row">
            <div class="col">
              <small id="emailHelp" class="form-text text-muted">Edad</small>
              <input type="number" min="1" max="99" class="form-control @error('edad') is-invalid @enderror" name="edad" placeholder="Edad">
              @error('edad')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="col">
              <small id="emailHelp" class="form-text text-muted">Grado</small>
              <select class="form-control" name="gradoId">
                <option value=0>Sin Grado</option>
                @forelse (App\Models\Grado::all() as $g)
                    <option value={{ $g->id }}>{{ $g->name }}</option>
                @empty
                    <option value=0 disabled>No hay grados registrados</option>
                @endforelse
              </select>
            </div>
          </div>
          {{--  MODALIDAD  --}}
          <div class="form-group">
            <small id="emailHelp" class="form-text text-muted">Modalidad</small>
              <select class="form-control" name="modalidadId">
                <option value=0>Sin Modalidad</option>
                @forelse (App\Models\Modalidad::all() as $m)
                    <option value={{ $m->id }}>{{ $m->name }}</option>
                @empty
                    <option value=0 disabled>No hay modalidades registradas</option>
                @endforelse
              </select>
          </div>
          <button type="submit" class="btn btn-primary float-right">Agregar</button>
      </form>
      </div>
    </div>
  </div>
</div>

@if ($errors->any())
  <script type="text/javascript">
    $( document ).ready(function() { $('#newStudentModal').modal('show'); });
  </script>
@endif
@endsection