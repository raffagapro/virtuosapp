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
                      <button class="btn btn-primary float-right" data-toggle="modal" data-target="#newTeacherModal">Agregar<i class="fas fa-book-reader ml-2"></i></button>
                    </div>
                  </div>
                  <table class="table table-bordered">
                    @if (count($teachers) > 0)
                      <thead>
                        <tr>
                          <th class="col-6 text-start"><h5>Nombre</h4></th>
                          <th><h5>Area</h4></th>
                          <th><h5>Actualizar</h4></th>
                        </tr>
                      </thead> 
                    @endif
                    <tbody>
                      @forelse ($teachers as $t)
                        <tr>
                          {{-- NOMBRE --}}
                          <td><a href="{{ route('maestros.show', $t->id) }}">{{ ucwords($t->name) }}</a></td>
                          {{-- GRADO --}}
                          @if (isset($t->area))
                            <td>{{ $t->area->name }}</td>
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
                                onclick="event.preventDefault(); document.getElementById('{{ 'teacherActivate'.$t->id }}').submit();">
                                <i class="fas fa-check"></i>
                              </a>
                              <form id="{{ 'teacherActivate'.$t->id }}"
                                action="{{ route('maestros.activate', $t->id) }}"
                                method="POST"
                                style="display: none;"
                                >@method('PUT') @csrf
                              </form>
                            @else
                              <a
                                href="javascript:void(0);"
                                class="btn btn-sm btn-danger text-light mr-2"
                                data-toggle="tooltip" data-placement="top" title="Desactivar"
                                onclick="event.preventDefault(); document.getElementById('{{ 'teacherDeactivate'.$t->id }}').submit();">
                                <i class="fas fa-times"></i>
                              </a>
                              <form id="{{ 'teacherDeactivate'.$t->id }}"
                                action="{{ route('maestros.deactivate', $t->id) }}"
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
                                  text: '¿Deseas eliminar al maestro?',
                                  showCancelButton: true,
                                  cancelButtonText: `Cancelar`,
                                  cancelButtonColor:'#62A4C0',
                                  confirmButtonColor:'red',
                                  confirmButtonText:'Eliminar',
                                  icon:'error',
                                }).then((result) => {
                                  if (result.isConfirmed) {
                                    document.getElementById('{{ 'delteacher'.$t->id }}').submit();
                                  }
                                });
                              ">
                              <i class="far fa-trash-alt"></i>
                            </a>
                            <form id="{{ 'delteacher'.$t->id }}"
                            action="{{ route('maestros.destroy', $t->id) }}"
                            method="POST"
                            style="display: none;"
                            >@csrf
                            @method('DELETE')
                            </form>
                          </td>
                        </tr>
                      @empty
                        <div class="alert alert-danger" role="alert">
                          Sin meastros
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

<!-- Modal Agregar Teacher -->
<div class="modal fade" id="newTeacherModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Maestro</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('maestros.store') }}" method="POST">
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
          {{--  Area  --}}
          <div class="form-group">
            <small id="emailHelp" class="form-text text-muted">Area</small>
              <select class="form-control" name="areaId">
                <option value=0>Sin Area</option>
                @forelse (App\Models\Area::all() as $a)
                    <option value={{ $a->id }}>{{ $a->name }}</option>
                @empty
                    <option value=0 disabled>No hay areas registradas</option>
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