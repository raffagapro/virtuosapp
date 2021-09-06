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
        <div class="col-md-3">
            <div class="card bgVirtuos border-secondary text-light text-center py-5">
                <div class="card-body">
                    <div class="mx-auto mb-3">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#uploadProfile">
                            <span class="fa-stack fa-5x">
                                @if (Auth::user()->perfil)
                                  <img src="{{ asset(Auth::user()->perfil) }}" class="chat-img">	
                                @else
                                  <i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
                                  <i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
                                @endif
                            </span>
                        </a>
                    </div>
                    <h3 class="mb-0" data-toggle="modal" data-target="#modAdminModal"><a class="text-white-50" href="javascript:void(0);">{{ Auth::user()->name }}</a></h3>
                    <p>
						<a href="javascript:void(0);" class="text-white-50" data-toggle="modal" data-target="#passwordModal">Modificar Contraseña</a>
					</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row mb-4">
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start" href="{{ route('estudiantes.index') }}">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Estudiantes</h4>
                            <img class="ml-auto panel-btn-icon" src="{{ asset('assets\images\student_icon.png') }}" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start" href="{{ route('materias.index') }}">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Materias</h4>
                            <img class="ml-auto panel-btn-icon" src="{{ asset('assets\images\classes_icon.png') }}" alt="">
                        </div>
                    </a>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start" href="{{ route('maestros.index') }}">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Maestros</h4>
                            <img class="ml-auto panel-btn-icon" src="{{ asset('assets\images\teacher_icon.png') }}" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start disabled">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Coordinadores</h4>
                            <img class="ml-auto panel-btn-icon" src="{{ asset('assets\images\staff_icon.png') }}" alt="">
                        </div>
                    </a>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start" href="{{ route('tutores.index') }}">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Tutores</h4>
                            <img class="ml-auto panel-btn-icon" src="{{ asset('assets\images\student_icon.png') }}" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a class="btn d-block btn-light border-secondary btn-text-start disabled">
                        <div class="card-body row px-5">
                            <h4 class="my-auto">Administración</h4>
                            <img class="ml-auto panel-btn-icon" src="{{ asset('assets\images\admin_icon.png') }}" alt="">
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Image Profile -->
<div class="modal fade" id="uploadProfile" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Foto de Perfil</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="retroFrom" action="{{ route('admin.profile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="userId" id="userId" value="{{ Auth::user()->id }}">
            {{--  FILE  --}}
            <div class="form-group">
              <input type="file" class="form-control-file @error('photoFile') is-invalid @enderror" name="photoFile">
              @error('photoFile')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <button type="submit" class="btn btn-primary float-right">Guardar</button>
        </form>
        </div>
      </div>
    </div>
</div>

<!-- Modal Modify Teacher -->
<div class="modal fade" id="modAdminModal" tabindex="-1">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title">Modificar Informacion</h5>
		  <button type="button" class="close" data-dismiss="modal">
			<span>&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form action="{{ route('admin.updateInfo', Auth::user()->id) }}" method="POST">
			@csrf
			@method('PUT')
			{{-- <input type="hidden" name="modUserName" value="{{ Auth::user()->username }}"> --}}
			{{--  NOMBRE  --}}
			<div class="form-group">
			  <input type="text" class="form-control @error('modNombre') is-invalid @enderror" name="modNombre" placeholder="Nombre" value="{{ Auth::user()->name }}">
			</div>
			{{--  USERNAME  --}}
			<div class="form-group">
				<input type="text" class="form-control @error('modUserName') is-invalid @enderror" name="modUserName" placeholder="Usuario" value="{{ Auth::user()->username }}">
			  </div>
			{{--  Email  --}}
			<div class="form-group">
			  <input type="mail" class="form-control @error('modEmail') is-invalid @enderror" name="modEmail" placeholder="Correo" value="{{ Auth::user()->email }}">
			</div>
			{{--  CURP  --}}
			<div class="form-group">
			  <input type="text" class="form-control @error('modCurp') is-invalid @enderror" name="modCurp" placeholder="CURP" value="{{ Auth::user()->curp }}">
			</div>
			<button type="submit" class="btn btn-primary float-right">Modificar</button>
		</form>
		</div>
	  </div>
	</div>
</div>

<!-- Password Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title">Cambiar Contraseña</h5>
		  <button type="button" class="close" data-dismiss="modal">
			<span>&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form action="{{ route('admin.updatePW', Auth::user()->id) }}" method="POST">
			@csrf
			@method('PUT')
			{{--  CURRENT PASSWORD  --}}
			<div class="form-group">
			  <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Contraseña">
			</div>
			<div class="form-group">
				<input type="password" class="form-control @error('nuevaContraseña') is-invalid @enderror" id="nuevaContraseña" name="nuevaContraseña" placeholder="Nueva Contraseña">
				@error('nuevaContraseña')
					<span class="invalid-feedback" role="alert">
						{{--  <strong>{{ $message }}</strong>  --}}
						<strong>La nueva contraseña es invalida o no concuerda</strong>
					</span>
				@enderror
			</div>
			<div class="form-group">
				<input type="password" class="form-control" id="nuevaContraseña_confirmation" name="nuevaContraseña_confirmation" placeholder="Confirmar Nueva Contraseña">
			</div>
			<button type="submit" class="btn btn-primary float-right">Modificar</button>
			<a href="{{ route('user.resetPW', Auth::user()->id) }}" type="submit" class="btn btn-warning float-right mr-1">Restablecer Contraseña</a>
		</form>
		</div>
	  </div>
	</div>
</div>

{{--  ALERTS  --}}
@if(session('status'))
	@if (session('eStatus') === null)
		<x-success-alert :message="session('status')"/>
	@else
		@if (session('eStatus') === 1)
			<x-success-alert :message="session('status')"/>
		@else
			<x-error-alert :message="session('status')"/>	
		@endif
	@endif
@endif
@isset($status)
	@if ($eStatus === null)
		<x-success-alert :message="$status"/>
	@else
		@if ($eStatus)
			<x-success-alert :message="$status"/>
		@else
			<x-error-alert :message="$status"/>
		@endif
	@endif
@endisset

@error('nuevaContraseña')
	<script type="text/javascript">
		$( document ).ready(function() {
		$('#passwordModal').modal('show');
	});
	</script>
@enderror
@endsection
