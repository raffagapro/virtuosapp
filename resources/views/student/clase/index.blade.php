@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = [$clase->label=>['studentDash.clase', $clase->id]]
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
@php
    $date = date('Y-m-d');
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card border-secondary text-center">
                <div class="card-body px-0">
                    <div class="my-3">
                        <h3>{{ $clase->label }}</h3>
                    </div>
                    <div class="py-3">
                        <table class="table">
                            <thead>
                                <tr class="border-top">
                                    <th class="col-6 text-left  border-right pl-5"><h5>Tareas</h4></th>
                                    <th class="border-right"><h5>Fecha de entrega</h4></th>
                                    <th class="pr-4"><h5>Status</h4></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $homeworkCounter = 0;@endphp
                                @forelse ($clase->homeworks->sortBy('edate', SORT_REGULAR, true) as $h)
                                    @if ($h->student === 0 || $h->student === Auth::user()->id )
                                        @php $homeworkCounter++;@endphp
                                        <tr>
                                            <td class="text-left border-right pl-5"><a href="{{ route('studentDash.tarea', $h->id) }}">{{ $h->title }}</a></td>
                                            @php
                                                $edate = date('M d', strtotime($h->edate));
                                            @endphp
                                            <td class="border-right">{{ $edate }}</td>
                                            @if (App\Models\StudentHomework::where('homework_id', $h->id)->where('user_id', Auth::user()->id)->first())
                                                <td class="pr-4"><span class="badge bg-info tarea-status">Complete</span></td>
                                            @else
                                                @if ($h->edate < $date)
                                                    <td class="pr-4"><span class="badge bg-danger tarea-status">Pendiente</span></td>
                                                @else
                                                    <td class="pr-4"><span class="badge bg-warning tarea-status">Nueva</span></td>
                                                @endif
                                            @endif                                            
                                        </tr>   
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="3">
                                            <div class="alert alert-danger" role="alert">
                                                Sin tareas
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- RIGHT PANEL --}}
        <div class="col-md-3">
            <div class="card bgVirtuos-docente border-secondary text-center py-5">
                <div class="card-body">
                    <div class="mx-auto mb-3">
                        <span class="fa-stack fa-5x">
                            <i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
                            <i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
                        </span>
                    </div>
                    <h3 class="mb-0">{{ Auth::user()->name }}</h3>
                    @if (isset(Auth::user()->grado))
                        <p class="text-secondary">{{ Auth::user()->grado->name }}</p>
                    @else
                        <p class="text-secondary">Sin Grado asignado</p>	
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
