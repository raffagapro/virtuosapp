@extends('layouts.app')

@section('subBar')
  @php
    $teacher = $clase->teacher();
    $crumbs = [
      "Maestros"=>['maestros.index'],
      $teacher->name=>['admin.teacherMonitor',$teacher->id],
      $clase->label=>['admin.teacherClaseMonitor', $clase->id]
    ]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <x-teacher.homework-panel :user="Auth::user()" :clase="$clase" :monitor="true"/>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/adminMonitorSwitcher.js') }}" ></script>
@endsection