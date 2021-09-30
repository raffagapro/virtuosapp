@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = []
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">

		{{--  LEFT PROFILE PANEL  --}}
        <div class="col-md-3">
			<x-profile-panel :user="Auth::user()"/>
        </div>

		{{--  CLASS PANEL   --}}
        <div class="col-md-4">
			<x-teacher.class-panel :user="Auth::user()"/>
        </div>

		{{--  MESSAGE PANEL  --}}
		<div class="col-md-4">
			<x-messages-panel :user="Auth::user()"/>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/teacherDashSwitcher.js') }}" ></script>
@endsection