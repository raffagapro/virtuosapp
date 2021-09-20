@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = [
      "Estudiantes"=>['estudiantes.index'],
      $student->name=>['admin.studentMonitor', $student->id]
	  ]
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
                      @if ($student->perfil)
                        <img src="{{ asset($student->perfil) }}" class="chat-img">	
                      @else
                        <i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
                        <i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
                      @endif
                    </span>
                  </div>
                  <h3 class="mb-0">{{ $student->name }}</h3>
                  @if (isset($student->grado))
                    <p class="text-white-50">{{ $student->grado->name }}</p>
                  @else
                    <p class="text-white-50">Sin Grado asignado</p>	
                  @endif
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card border-secondary px-3">
                <div class="card-body">
                    <table class="table text-center">
                        <thead>
                          <tr>
                            <th class="col-9 text-left"><h5>Clases</h4></th>
                            <th class="col-3"><h5>Status</h4></th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($student->clases as $c)
                            <tr>
                              <td class="text-left">
                                <a href="{{ route('admin.studentMonitorClase', [$c->id, $student->id]) }}">{{ $c->label }}</a>
                              </td>
                              @php
                                  $hws = $c->homeworks->all();
                                  $pendingHomeworks = false;
                                  $turnedHomeworks = false;
                                  foreach ($hws as $thw) {
                                    if ($thw->student === 0 || $thw->student === $student->id) {
                                      if (!App\Models\StudentHomework::where('homework_id', $thw->id)->where('user_id', $student->id)->first()) {
                                        $pendingHomeworks = true;
                                      }else {
                                        if (App\Models\StudentHomework::where('homework_id', $thw->id)->where('user_id', $student->id)->first()->status !== 2) {
                                          $pendingHomeworks = true;
                                          if (App\Models\StudentHomework::where('homework_id', $thw->id)->where('user_id', $student->id)->first()->status === 1) {
                                            $turnedHomeworks = true;
                                          }
                                        }
                                      }
                                    }
                                  }
                              @endphp
                              <td>
                                @if ($pendingHomeworks)
                                  @if ($turnedHomeworks)
                                    <span class="badge bg-warning tarea-status">Entregado</span> 
                                  @else
                                    <span class="badge bg-danger tarea-status">Pendiente</span> 
                                  @endif
                                @else
                                  <span class="badge bg-info tarea-status">Complete</span>
                                @endif
                              </td>
                            </tr>
                          @empty
                              
                          @endforelse
                        </tbody>
                    </table>
                </div>
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
@endsection
