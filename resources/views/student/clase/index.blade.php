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
                                            @php
                                                $foundHomework = App\Models\StudentHomework::where('homework_id', $h->id)->where('user_id', Auth::user()->id)->first();
                                            @endphp
                                            @if ($foundHomework)
                                                @if ($foundHomework->status === 0 || $foundHomework->status === null)
                                                    <td class="pr-4"><span class="badge bg-danger tarea-status">Pendiente</span></td>
                                                @endif
                                                @if ($foundHomework->status === 1)
                                                    <td class="pr-4"><span class="badge bg-info tarea-status">Enviada</span></td>
                                                @endif
                                                @if ($foundHomework->status === 2)
                                                    <td class="pr-4"><span class="badge bg-info tarea-status">Complete</span></td>
                                                @endif
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
                            @if ($clase->teacher !== 0)
                                @if ($clase->teacher()->perfil)
                                    <img src="{{ asset($clase->teacher()->perfil) }}" class="chat-img">	
                                @else
                                    <i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
                                    <i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i> 
                                @endif
                            @else
                                <i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
                                <i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
                            @endif
                        </span>
                    </div>
                    <h3 class="mb-0">{{ $clase->teacher()->name }}</h3>
                    @if (isset($clase->teacher()->area))
                        <p class="text-secondary">{{ $clase->teacher()->area->name }}</p>
                    @else
                        <p class="text-secondary">Sin Area asignada</p>	
                    @endif
                    {{--  ZOOM BTN  --}}
                    <a href="{{ $clase->zlink }}" type="button" class="btn btn-link p-0 @if ($clase->zlink === null) disabled @endif" target="_blank" data-toggle="tooltip" data-placement="top" title="Clase Zoom">
                        <span class="fa-stack fa-lg">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-video fa-sm fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                    {{--  MESSAGE BTN  --}}
                    <a href="javascript:void(0);" type="button" id="{{ $foundChat->id }}" class="btn btn-link p-0 messageBtn @if ($clase->teacher === 0) disabled @endif" data-toggle="modal" data-target="#chatModal">
                        <span class="fa-stack fa-lg" data-toggle="tooltip" data-placement="top" title="Contactar al Docente">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-comments fa-sm fa-stack-1x fa-inverse"></i>
                        </span>
                        @php
							$unreadMessages = 0;
                            // dd($foundChat->chatMessages);
                            foreach ($foundChat->chatMessages as $cmw) {
								if ($cmw->user_id !== Auth::user()->id && $cmw->status === 0) {
									$unreadMessages++;
								}
							}
                        @endphp
                        @if ($unreadMessages > 0)
                            <span class="badge badge-danger float-right" style="margin-left:-150px">{{ $unreadMessages }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chat Modal -->
<div class="modal fade" id="chatModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-scrollable">
	  <div class="modal-content">
		<div class="modal-header">
            <span class="fa-stack fa-lg mr-2">
                @if ($clase->teacher()->perfil)
                    <img src="{{ asset($clase->teacher()->perfil) }}" class="mini-img">	
                @else
                    <i class="fas fa-circle fa-stack-2x text-light"></i>
                    <i class="fas fa-user fa-stack-1x fa-sm text-secondary"></i>
                @endif
            </span>
            <h4 class="modal-title">{{ $clase->teacher()->name }}</h4>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
		</div>
		<div class="modal-body">
            <div id="messageCont">
                @forelse ($foundChat->chatMessages->sortBy('created_at', SORT_REGULAR, true) as $cm)
                    @if ($cm->user_id === Auth::user()->id)
                        <div class="row mr-2">
                            <div class="col-2"></div>
                            <div class="alert alert-light col" role="alert">
                                <p>{{ $cm->body }}</p>
                                <hr class="m-1">
                                <small class="mb-0 text-right text-small">11:30am</small>
                            </div>
                        </div>
                    @else
                        <div class="row ml-2">
                            <div class="alert alert-info col-10" role="alert">
                                <p>{{ $cm->body }}</p>
                                <hr class="m-1">
                                <div class="row justify-content-end">
                                    <small class="mb-0 mr-3">11:30am</small>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="text-muted">Sin mensajes registrados...</p>
                @endforelse
            </div>
		</div>
        <div class="modal-footer">
            {{--  SEND MESSAGE FORM  --}}
            <form action="{{ route('chatStudent.store') }}" method="POST" class="m-auto w-100">
                @csrf
                <input type="hidden" name="senderId" id="senderId" value="{{ Auth::user()->id }}">
                <input type="hidden" name="recieverId" id="recieverId" value="{{ $clase->teacher()->id }}">
                @if ($foundChat)
                    <input type="hidden" name="chatId" id="chatId" value="{{ $foundChat->id }}"> 
                @endif
                <div class="form-row">
                    <div class="col-10">
                        <input type="text" autocomplete="off" class="form-control" name="messageBody" id="messageBody" placeholder="Escribe tu mensaje...">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <i class="far fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </form>
	    </div>
        
	  </div>
	</div>
</div>

@if(session('chatGo'))
	@if ((int)session('chatGo') !== 0)
        <script type="text/javascript">
            $( document ).ready(function() {
            $('#chatModal').modal('show');
        });
        </script>
	@endif
@endif
@endsection

@section('scripts')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<script src="{{ asset('js/ajax/studenDashMessageMarker.js') }}" ></script>
@endsection
