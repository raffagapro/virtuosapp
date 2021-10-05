@extends('layouts.app')

@section('subBar')
  @php
    // $crumbs = [$homework->clase->label=>['maestroDash.clase', $homework->clase->id], $homework->title=>['maestroDash.tarea', $homework->id]]
    $crumbs = [$teacher->name=>['coordinatorDash.monitor', $teacher->id]]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">

		{{--  LEFT PROFILE PANEL  --}}
    <div class="col-md-3">
      <x-profile-panel :user="$teacher" :monitor="true"/>
    </div>

		{{--  CLASS PANEL   --}}
    <div class="col-md-4">
      <x-teacher.class-panel :user="$teacher" :monitor="true"/>
    </div>

    {{--  MESSAGE PANEL  --}}
    <div class="col-md-4">
      <x-messages-panel :user="$teacher" :monitor="true"/>
    </div>
    
  </div>
</div>
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/teacherMonitorSwitcher.js') }}" ></script>
@endsection