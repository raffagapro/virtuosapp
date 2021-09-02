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
						<span class="fa-stack fa-5x">
							<i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
							<i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
						</span>
                    </div>
                    <h3 class="mb-0" data-toggle="modal" data-target="#modTeacherModal"><a class="text-white-50" href="javascript:void(0);">{{ Auth::user()->name }}</a></h3>
					@if (isset(Auth::user()->area))
                    	<p class="text-white-50">{{ Auth::user()->area->name }}</p>
					@else
						<p class="text-white-50">Sin Area asignada</p>	
					@endif
					<p>
						<a href="javascript:void(0);" class="text-white-50" data-toggle="modal" data-target="#passwordModal">Modificar Contraseña</a>
					</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th><h5>Clases</h5></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
							@forelse (App\Models\Clase::where('teacher', Auth::user()->id)->where('status', '1')->orderBy('label')->get() as $c)
								<tr>
									<td class="align-middle"><a href="{{ route('maestroDash.clase', $c->id) }}">{{ $c->label }}</a></td>
									<td class="align-middle text-right py-0">
										<button type="button" class="btn btn-link zoomModalBtn" id="{{ $c->id }}" data-toggle="modal" data-target="#zoomModal">
											<span class="fa-stack fa-lg">
												<i class="fas fa-circle fa-stack-2x"></i>
												<i class="fas fa-video fa-sm fa-stack-1x fa-inverse"></i>
											</span>
										</button>
									</td>
							  	</tr>
							@empty
								<tr>
									<td class="align-middle">Sin clases registradas</td>
								</tr>
							@endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

		<div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-body">
					<h5>Mensajes</h5>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Zoom Modal -->
<div class="modal fade" id="zoomModal" tabindex="-1">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title">Zoom - <span id="classNameCont"></span></h5>
		  <button type="button" class="close" data-dismiss="modal">
			<span>&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form action="{{ route('clase.setZlink') }}" method="POST">
			@csrf
			<input type="hidden" id="claseID" name="claseID">
			{{--  LINK  --}}
			<div class="form-group">
			  <input type="text" class="form-control" id="zlink" name="zlink" placeholder="LINK">
			</div>
			<button type="submit" class="btn btn-primary float-right">Guardar</button>
			<a href="javascript:void(0);" class="btn btn-danger float-right mr-1" id="zoomBtn" target="_blank">
				<i class="fas fa-video" data-toggle="tooltip" data-placement="top" title="Abrir Zoom"></i>
			</a>
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
		  <form action="{{ route('maestro.updatePW', Auth::user()->id) }}" method="POST">
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

<!-- Modal Modify Teacher -->
<div class="modal fade" id="modTeacherModal" tabindex="-1">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title">Modificar Informacion</h5>
		  <button type="button" class="close" data-dismiss="modal">
			<span>&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form action="{{ route('maestro.updateInfo', Auth::user()->id) }}" method="POST">
			@csrf
			@method('PUT')
			{{--  NOMBRE  --}}
			<div class="form-group">
			  <input type="text" class="form-control" name="modNombre" placeholder="Nombre" value="{{ Auth::user()->name }}">
			</div>
			{{--  Email  --}}
			<div class="form-group">
			  <input type="mail" class="form-control" name="modEmail" placeholder="Correo" value="{{ Auth::user()->email }}">
			</div>
			{{--  CURP  --}}
			<div class="form-group">
			  <input type="text" class="form-control" name="modCurp" placeholder="CURP" value="{{ Auth::user()->curp }}">
			</div>
			<button type="submit" class="btn btn-primary float-right">Modificar</button>
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
@php
	dd($eStatus);
@endphp
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

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/teacherDashSwitcher.js') }}" ></script>
@endsection