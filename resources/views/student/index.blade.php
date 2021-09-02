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
        <div class="col-md-3">
            <div class="card bgVirtuos border-secondary text-light text-center py-5">
                <div class="card-body">
                  <div class="mx-auto mb-3">
                    <span class="fa-stack fa-5x">
                      <i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
                      <i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
                    </span>
                  </div>
                  <h3 class="mb-0">{{ Auth::user()->name }}</h3>
                  @if (isset(Auth::user()->grado))
                    <p class="text-white-50">{{ Auth::user()->grado->name }}</p>
                  @else
                    <p class="text-white-50">Sin Grado asignado</p>	
                  @endif
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card border-secondary px-3">
                <div class="card-body">
                    <table class="table text-center">
                        <thead>
                          <tr>
                            <th class="col-9 text-left"><h5>Clases</h4></th>
                            <th class="col-3"><h5>Status</h4></th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse (Auth::user()->clases as $c)
                            <tr>
                              <td class="text-left"><a href="{{ route('studentDash.clase', $c->id) }}">{{ $c->label }}</a></td>
                              <td><span class="badge bg-info tarea-status">Complete</span></td>
                              {{--  <td><span class="badge bg-warning tarea-status">Nueva</span></td>
                              <td><span class="badge bg-danger tarea-status">Pendiente</span></td>  --}}
                            </tr>
                          @empty
                              
                          @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
