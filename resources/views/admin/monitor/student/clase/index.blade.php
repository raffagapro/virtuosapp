@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = [
      "Estudiantes"=>['estudiantes.index'],
      $student->name=>['admin.studentMonitor', $student->id],
      $clase->label=>['admin.studentMonitorClase', [$clase->id, $student->id]]
	]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
@php
    $date = date('Y-m-d');
@endphp
<div class="container">
    <div class="row justify-content-center">

        {{--  HOMEWORK PANEL  --}}
        <div class="col-md-9">
            <x-student.homework-panel :user="$student" :clase="$clase" :monitor="true"/>
        </div>
        
        {{-- TEACHER PROFILE PANEL --}}
        <div class="col-md-3">
            <x-student.teacher-profile-panel :user="$student" :clase="$clase" :monitor="true"/>
        </div>
    </div>
</div>
@endsection
