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
          <x-student-class-panel :user="$student" :monitor="true"/>
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
