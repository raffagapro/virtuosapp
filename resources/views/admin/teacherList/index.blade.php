@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Meastros"=>'teacherList']
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
                    <h3 class="col-4">Maestros</h3>
                    <div class="col-4">
                      <button class="btn btn-primary float-right" data-toggle="modal" data-target="#newStudentModal">Agregar<i class="fas fa-book-reader ml-2"></i></button>
                    </div>
                  </div>
                  <table class="table table-bordered">
                    @if (count($teachers) > 0)
                      <thead>
                        <tr>
                          <th class="col-6 text-start"><h5>Nombre</h4></th>
                          <th><h5>Grado</h4></th>
                          <th><h5>Actualizar</h4></th>
                        </tr>
                      </thead> 
                    @endif
                    <tbody>
                      @forelse ($teachers as $t)
                        <tr>
                          {{-- NOMBRE --}}
                          <td><a href="{{ route('estudiantes.show', $t->id) }}">{{ ucwords($t->name) }}</a></td>
                          {{-- GRADO --}}
                          @if (isset($t->grado))
                            <td>{{ $t->grado->name }}</td>
                          @else
                              <td>-</td>
                          @endif
                          {{-- ACTUALIZAR --}}
                          <td>
                            @if ($t->status === 0)
                              <a
                                href="javascript:void(0);"
                                class="btn btn-sm btn-success text-light mr-2"
                                data-toggle="tooltip" data-placement="top" title="Activar"
                                onclick="event.preventDefault(); document.getElementById('{{ 'studentActivate'.$t->id }}').submit();">
                                <i class="fas fa-check"></i>
                              </a>
                              <form id="{{ 'studentActivate'.$t->id }}"
                                action="{{ route('estudiantes.activate', $t->id) }}"
                                method="POST"
                                style="display: none;"
                                >@method('PUT') @csrf
                              </form>
                            @else
                              <a
                                href="javascript:void(0);"
                                class="btn btn-sm btn-danger text-light mr-2"
                                data-toggle="tooltip" data-placement="top" title="Desactivar"
                                onclick="event.preventDefault(); document.getElementById('{{ 'studentDeactivate'.$t->id }}').submit();">
                                <i class="fas fa-times"></i>
                              </a>
                              <form id="{{ 'studentDeactivate'.$t->id }}"
                                action="{{ route('estudiantes.deactivate', $t->id) }}"
                                method="POST"
                                style="display: none;"
                                >@method('PUT') @csrf
                              </form>
                            @endif
                            <a
                            href="javascript:void(0);"
                            class="btn btn-danger btn-sm text-light"
                            data-toggle="tooltip" data-placement="top" title="Borrar"
                            onclick="
                                event.preventDefault();
                                swal.fire({
                                  text: '¿Deseas eliminar el estudiante?',
                                  showCancelButton: true,
                                  cancelButtonText: `Cancelar`,
                                  cancelButtonColor:'#62A4C0',
                                  confirmButtonColor:'red',
                                  confirmButtonText:'Eliminar',
                                  icon:'error',
                                }).then((result) => {
                                  if (result.isConfirmed) {
                                    document.getElementById('{{ 'delStudent'.$t->id }}').submit();
                                  }
                                });
                              ">
                              <i class="far fa-trash-alt"></i>
                            </a>
                            <form id="{{ 'delStudent'.$t->id }}"
                            action="{{ route('estudiantes.destroy', $t->id) }}"
                            method="POST"
                            style="display: none;"
                            >@csrf
                            @method('DELETE')
                            </form>
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
                  {{$teachers->links()}}
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
            <input type="text" class="form-control" name="nombre" placeholder="Nombre">
          </div>
          {{--  Email  --}}
          <div class="form-group">
            <input type="mail" class="form-control" name="email" placeholder="Correo">
          </div>
          {{--  CURP  --}}
          <div class="form-group">
            <input type="text" class="form-control" name="curp" placeholder="CURP">
          </div>
          {{-- EDAD / GRADO --}}
          <div class="form-group row">
            <div class="col">
              <small id="emailHelp" class="form-text text-muted">Edad</small>
              <input type="number" min="1" max="99" class="form-control" name="age" placeholder="Edad">
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

@if(session('status'))
  <x-success-alert :message="session('status')"/>
@endif
@isset($status)
  <x-success-alert :message="$status"/>
@endisset
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/materiaSwitcher.js') }}" ></script>
@endsection


          {{--  TUTOR  --}}
          {{--  <div class="form-group">
            @php
                $tutores = App\Models\User::whereHas(
                    'role', function($q){
                        $q->where('name', 'guardian');
                    }
                )->get();
              @endphp
              <small id="emailHelp" class="form-text text-muted">Tutor</small>
              <select class="form-control" name="teacherId">
                <option value=0>Sin Tutor</option>
                @forelse ($tutores as $t)
                    <option value={{ $t->id }}>{{ $t->name }}</option>
                @empty
                    <option value=0 disabled>No hay tutores registrados</option>
                @endforelse
              </select>
          </div>  --}}