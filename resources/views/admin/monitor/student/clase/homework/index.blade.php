@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = [
      "Estudiantes"=>['estudiantes.index'],
      $student->name=>['admin.studentMonitor', $student->id],
      $homework->clase->label=>['admin.studentMonitorClase', [$homework->clase->id, $student->id]],
      $homework->title=>['admin.studentMonitorTarea', [$homework->id, $student->id]]
	  ]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- MAIN PANEL --}}
        <div class="col-md-12">
            <div class="card border-secondary">
                <div class="card-header text-center">
                    <div class="my-3">
                        <h5>Instrucciones</h5>
                        <p>Docente: {{ $homework->clase->teacher()->name }}</p>
                    </div>
                </div>

                <div class="card-body px-5">
                  <p class="">
                    {!! $homework->body !!}
                  </p>
                </div>

                <div class="card-footer px-5">
                    <div class="row">

                      @if (App\Models\StudentHomework::where('homework_id', $homework->id)->where('user_id', $student->id)->first())
                        @if (App\Models\StudentHomework::where('homework_id', $homework->id)->where('user_id', $student->id)->first()->media === null)
                          <div class="ml-auto mr-3">  
                            <button class="btn btn-secondary text-white" data-toggle="modal" data-target="#uploadHomework" disabled>Subir Tarea</button>
                          </div>
                        @else
                          <div class="ml-auto mr-3">
                            <button class="btn btn-dark" data-toggle="modal" data-target="#uploadHomework" disabled>Reemplazar Tarea</button>
                          </div>
                          <div class="mr-3">
                            <a href="{{ asset(App\Models\StudentHomework::where('homework_id', $homework->id)->where('user_id', $student->id)->first()->media) }}" class="btn btn-dark text-white" data-toggle="tooltip" data-placement="top" title="Mi Tarea" target="_blank">
                              <i class="fas fa-book"></i>
                            </a>
                          </div> 
                        @endif
                      @else
                        <div class="ml-auto mr-3">
                          <button class="btn btn-secondary text-white" data-toggle="modal" data-target="#uploadHomework" disabled>Subir Tarea</button>
                        </div>
                        <div class="mr-3">
                          <a href="{{ route('studentDash.done', [$homework->id, $student->id]) }}" class="btn btn-dark text-white disabled" data-toggle="tooltip" data-placement="top" title="Marcar Completada">
                            <i class="fas fa-check"></i>
                          </a>
                        </div>
                      @endif

                      @if ($homework->vlink !== null && $homework->vlink !== '')
                        <div class="mr-3">
                          <a href="{{ $homework->vlink }}" class="btn btn-danger text-white" target="_blank">Ver Video</a>
                        </div>
                      @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- RETRO --}}
        @if (App\Models\Retro::where('homework_id', $homework->id)->where('user_id', $student->id)->first())
          <div class="col-md-12 mt-4">
            <div class="card border-secondary text-center">
                <div class="card-header">
                  <div class="my-3">
                      <h5>Retroalimentacion</h5>
                  </div>
                </div>
                <div class="card-body px-5">
                  <p class="text-justify">{{ App\Models\Retro::where('homework_id', $homework->id)->where('user_id', $student->id)->first()->body }}</p>
                </div>
            </div>
          </div> 
        @endif

        {{-- FILES --}}
      @if (count($homework->medias) > 0)
        <div class="col-md-12 mt-4">
          <div class="card border-secondary text-center">
              <div class="card-header">
                <div class="my-3">
                    <h5>Archivos</h5>
                </div>
              </div>
              <div class="card-body px-5">
                <table class="table">
                  <tbody>
                    @forelse ($homework->medias as $hm)
                        <tr>
                          <td class="align-middle">
                            <a href="{{ asset($hm->media) }}" target="_blank">{{ str_replace('https://virtuousapp.s3.us-east-2.amazonaws.com/tHomework/', '', $hm->media) }}</a>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td class="align-middle">Sin archivos registrados</td>
                        </tr>
                      @endforelse
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      @endif
        
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
{{-- @php
	dd($eStatus);
@endphp --}}
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
@endsection
