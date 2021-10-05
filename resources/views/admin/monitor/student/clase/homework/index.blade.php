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
          <x-homework.main-panel :user="$student" :homework="$homework" :monitor="true"/>
        </div>

        {{-- RETRO --}}
        @if (App\Models\Retro::where('homework_id', $homework->id)->where('user_id', $student->id)->first())
          <x-homework.retro-panel :user="$student" :homework="$homework"/> 
        @endif

        {{-- FILES --}}
      @if (count($homework->medias) > 0)
        <div class="col-md-12 mt-4">
          <x-homework.teacher-files-panel :user="$student" :homework="$homework"/>
        </div>
      @endif
        
    </div>
</div>
@endsection
