@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = ["Coordinador"=>['coordinator.index'], $coordinator->name => ['coordinator.edit', $coordinator->id]]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-secondary text-center">
        <div class="card-body">
          <div class="row mb-4">
            <div class="col-2">
              <span class="fa-stack fa-4x">
                @if ($coordinator->perfil)
                  <img src="{{ asset($coordinator->perfil) }}" class="chat-img">	
                @else
                  <i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
                  <i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
                @endif
              </span>
            </div>
            <div class="col-10 text-left pl-0">
              <h4>{{ $coordinator->name }}</h4>
              <div class="row">
                <div class="col-9">
                  <div class="row">
                    <div class="col-5">
                      {{-- Area --}}
                      @if (isset($coordinator->area))
                        <p>{{ $coordinator->area->name }}</p>
                      @else
                        <p class="text-danger">Area sin asignar</p> 
                      @endif
                      {{-- UserName --}}
                      @if (isset($coordinator->username))
                        <p>{{ $coordinator->username }}</p>
                      @else
                        <p class="text-danger">Usuario sin asignar</p> 
                      @endif
                      {{-- Email --}}
                      @if (isset($coordinator->email))
                      <p>{{ $coordinator->email }}</p>
                      @else
                        <p class="text-danger">Email sin asignar</p> 
                      @endif
                    </div>
                    <div class="col-7 pl-0">
                      {{-- CURP --}}
                      @if (isset($coordinator->curp))
                      <p>{{ strtoupper($coordinator->curp) }}</p>
                      @else
                        <p class="text-danger">CURP sin asignar</p> 
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="row">
                    <div class="col text-right pl-0">
                      {{--  MODIFY TEACHER BTN  --}}
                      <button class="btn btn-primary" data-toggle="modal" data-target="#modCordModal">
                        <i class="fas fa-pen fa-fw" data-toggle="tooltip" data-placement="top" title="Modificar Coordinador"></i>
                      </button>
                      {{--  ADD TEACHER BTN  --}}
                      <button class="btn btn-info" data-toggle="modal" data-target="#addTeacherModal">
                        <i class="fas fa-plus fa-fw" data-toggle="tooltip" data-placement="top" title="Agregar Maestro"></i>
                      </button>
                      {{--  DELETE COORD BTN  --}}
                      <x-delete-btn
                        :tooltip="'Eliminar Coordinador'"
                        :id="[$coordinator->id]"
                        :text="'¿Deseas eliminar al coordinador?'"
                        :elemName="'delCoord'"
                        :routeName="'coordinator.destroy'"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <table class="table table-bordered">
            @if (count($coordinator->coordinators()) > 0)
              <thead>
                <tr>
                  <th class="col-9 text-left"><h5>Maestros</h5></th>
                  @if ($coordinator->status === 1)
                    <th class="col-3"><h5>Eliminar</h5></th>
                  @endif
                </tr>
              </thead>
            @endif
            <tbody>
              @forelse ($coordinator->coordinators() as $c)
                @php
                    $t = $c->getTeacher();
                @endphp
                <tr>
                  {{-- NOMBRE --}}
                  <td class="text-left"><a href="{{ route('maestros.edit', $t->id) }}">{{ ucwords($t->name) }}</a></td>
                  @if ($coordinator->status === 1)
                    {{-- ACTUALIZA --}}
                    <td>
                      <x-delete-btn
                        :tooltip="'Eliminar'"
                        :id="[$c->id]"
                        :text="'¿Deseas eliminar al maestro?'"
                        :elemName="'delTeacher'"
                        :routeName="'coordinator.rmTeacher'"
                      />
                    </td>
                  @endif
                </tr>
              @empty
                <div class="alert alert-danger" role="alert">
                  Sin maestros registrados
                </div>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Coord Teacher -->
<div class="modal fade" id="modCordModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modificar Coordinador</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('coordinator.update', $coordinator->id) }}" method="POST">
          @csrf
          @method('PUT')
          {{--  NOMBRE  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modNombre') is-invalid @enderror" name="modNombre" value="{{ $coordinator->name }}" placeholder="Nombre">
            @error('modNombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  USUARIO  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modUserName') is-invalid @enderror" name="modUserName" value="{{ $coordinator->username }}" placeholder="Usuario">
            @error('modUserName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  Email  --}}
          <div class="form-group">
            <input type="mail" class="form-control @error('modEmail') is-invalid @enderror" name="modEmail" value="{{ $coordinator->email }}" placeholder="Correo">
            @error('modEmail')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  CURP  --}}
          <div class="form-group">
            <input type="text" class="form-control @error('modCurp') is-invalid @enderror" name="modCurp" value="{{ $coordinator->curp }}" placeholder="CURP">
            @error('modCurp')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          {{--  AREA  --}}
          <div class="form-group">
            <small id="emailHelp" class="form-text text-muted">Area</small>
              <select class="form-control" name="modAreaId">
                <option value=0>Sin Area</option>
                @forelse (App\Models\Area::all() as $a)
                @if (isset($coordinator->area))
                  @if ($a->id === $coordinator->area->id)
                    <option value={{ $a->id }} selected>{{ $a->name }}</option> 
                  @else
                    <option value={{ $a->id }}>{{ $a->name }}</option>
                  @endif
                @else
                  <option value={{ $a->id }}>{{ $a->name }}</option>
                @endif
                @empty
                    <option value=0 disabled>No hay areas registradas</option>
                @endforelse
              </select>
          </div>

          <button type="submit" class="btn btn-primary float-right">Modificar</button>
          <a href="{{ route('user.resetPW', $coordinator->id) }}" type="submit" class="btn btn-warning float-right mr-1">Restablecer Password</a>
      </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar Teacher -->
<div class="modal fade" id="addTeacherModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modTitleCont">Agregar Maestro</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="teacherSearch" placeholder="Nombre del Maestro">
          <input type="hidden" id="coordId" value="{{ $coordinator->id }}">
        </div>
        <table class="table table-bordered">
          <tbody id="teacherListCont">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@if ($errors->any())
  <script type="text/javascript">
    $( document ).ready(function() { $('#modTeacherModal').modal('show'); });
  </script>
@endif

@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/coordIndvSwitcher.js') }}" ></script>
@endsection
