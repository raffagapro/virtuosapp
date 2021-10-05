@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = [$clase->label=>['maestroDash.clase', $clase->id]]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <x-teacher.homework-panel :user="Auth::user()" :clase="$clase"/>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/teacherDashHomeworkSwitcher.js') }}" ></script>
@endsection