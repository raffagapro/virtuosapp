@extends('layouts.app')

@section('subBar')
  @php
    $teacher = $homework->clase->teacher();
    $crumbs = [
      "Maestros"=>['maestros.index'],
      $teacher->name=>['admin.teacherMonitor',$teacher->id],
      $homework->clase->label=>['admin.teacherClaseMonitor', $homework->clase->id],
      $homework->title=>['admin.teacherMonitorTareaIndv', $homework->id]
    ]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
      {{-- MAIN PANEL --}}
      <div class="col-md-12">
        <x-homework.main-panel :user="Auth::user()" :homework="$homework" :monitor="true"/>
      </div>
      
      {{-- FILES --}}
      @if (count($homework->medias) > 0)
        <div class="col-md-12 mt-4">
          <x-homework.teacher-files-panel :user="Auth::user()" :homework="$homework" :monitor="true"/>
        </div>
      @endif

      {{-- ALUMNOS --}}
      <div class="col-md-12 mt-4">
        <x-homework.student-panel :homework="$homework" :monitor="true"/>
        {{-- AJAX IS CHANGING THE MODAL FROM ACTION FRO THIS COMPONENT --}}
      </div>
  </div>
</div>

@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/adminMonitorSwitcher.js') }}" ></script>
@endsection
