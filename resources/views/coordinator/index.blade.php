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

		{{--  TEACHER PANEL   --}}
        <div class="col-md-8">
            <div class="card border-secondary">
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th><h5>Maestros</h5></th>
                          </tr>
                        </thead>
                        <tbody>
							@forelse (Auth::user()->coordinators() as $cObj)
								@php
									$c = $cObj->getTeacher();
								@endphp
								<tr>
									<td class="align-middle"><a href="{{ route('coordinatorDash.monitor', $c->id) }}">{{ $c->name }}</a></td>
							  	</tr>
							@empty
								<tr>
									<td class="align-middle">Sin clases registradas</td>
								</tr>
							@endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/teacherDashSwitcher.js') }}" ></script>
@endsection