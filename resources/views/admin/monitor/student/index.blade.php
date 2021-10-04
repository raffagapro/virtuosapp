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

		{{--  PROFILE PANEL  --}}
        <div class="col-md-3">
          <x-profile-panel :user="$student" :monitor="true"/>
        </div>

		{{--  CLASSES PANEL  --}}
        <div class="col-md-9">
          	<x-student.class-panel :user="$student" :monitor="true"/>
        </div>
    </div>
</div>
@endsection
