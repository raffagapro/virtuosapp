@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Super Admin"=>'superAdmin']
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
                    <h3 class="col-4">Roles</h3>
                    <div class="col-4">
                      <button class="btn btn-primary float-right" data-toggle="modal" data-target="#newRole">Agregar<i class="fas fa-book-reader ml-2"></i></button>
                    </div>
                  </div>
                  <table class="table table-bordered">
                    @if (count(App\Models\Role::all()) > 0)
                      <thead>
                        <tr>
                          <th class="col-9 text-start"><h5>Nombre</h4></th>
                          <th><h5>Actualizar</h4></th>
                        </tr>
                      </thead> 
                    @endif
                    <tbody>
                      @forelse (App\Models\Role::all() as $r)
                        <tr>
                          {{-- NOMBRE --}}
                          <td><a href="{{ route('estudiantes.edit', $r->id) }}">{{ ucwords($r->name) }}</a></td>
                          {{-- ACTUALIZAR --}}
                          <td>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary text-light mr-2 modBtn" id="{{ $r->id }}" data-toggle="modal" data-target="#modRole">
                              <i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Editar"></i>
                            </a>
                            <a
                            href="javascript:void(0);"
                            class="btn btn-danger btn-sm text-light"
                            data-toggle="tooltip" data-placement="top" title="Borrar"
                            onclick="
                                event.preventDefault();
                                swal.fire({
                                  text: '¿Deseas eliminar el role?',
                                  showCancelButton: true,
                                  cancelButtonText: `Cancelar`,
                                  cancelButtonColor:'#62A4C0',
                                  confirmButtonColor:'red',
                                  confirmButtonText:'Eliminar',
                                  icon:'error',
                                }).then((result) => {
                                  if (result.isConfirmed) {
                                    document.getElementById('{{ 'delRole'.$r->id }}').submit();
                                  }
                                });
                              ">
                              <i class="far fa-trash-alt"></i>
                            </a>
                            <form id="{{ 'delRole'.$r->id }}"
                            action="{{ route('sa.delRole', $r->id) }}"
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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Role -->
<div class="modal fade" id="newRole" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Role</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('sa.newRole') }}" method="POST">
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
          <button type="submit" class="btn btn-primary float-right">Agregar</button>
      </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modify Role -->
<div class="modal fade" id="modRole" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modificar Role - <span id="roleNameCont"></span></h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('sa.updateRole', 0) }}" id="modRoleFrom" method="POST">
          @csrf
          @method('PUT')
          {{--  NOMBRE  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modNombre') is-invalid @enderror" name="modNombre" id="modNombre" placeholder="Nombre">
            @error('modNombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <button type="submit" class="btn btn-primary float-right">Modificar</button>
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

@if(session('status'))
  <x-success-alert :message="session('status')"/>
@endif
@isset($status)
  <x-success-alert :message="$status"/>
@endisset
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/saSwitcher.js') }}" ></script>
@endsection