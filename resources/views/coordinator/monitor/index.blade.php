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
            <div class="card bgVirtuos border-secondary text-light text-center py-5">
                <div class="card-body">
                    <div class="mx-auto mb-3">
						<span>
							<span class="fa-stack fa-5x">
								@if ($teacher->perfil)
									<img src="{{ asset($teacher->perfil) }}" class="chat-img">	
								@else
									<i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
									<i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
								@endif
							</span>
						</span>
                    </div>
                    <h3 class="mb-0">{{ $teacher->name }}</h3>
					@if (isset($teacher->area))
                    	<p class="text-white-50">{{ $teacher->area->name }}</p>
					@else
						<p class="text-white-50">Sin Area asignada</p>	
					@endif
                </div>
            </div>
        </div>

		{{--  CLASS PANEL   --}}
        <div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th><h5>Clases</h5></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
							@forelse (App\Models\Clase::where('teacher', $teacher->id)->where('status', '1')->orderBy('label')->get() as $c)
								<tr>
									<td class="align-middle"><a href="{{ route('monitor.clase', $c->id) }}">{{ $c->label }}</a></td>
									<td class="align-middle text-right py-0">
										<button type="button" class="btn btn-link zoomModalBtn" id="{{ $c->id }}" data-toggle="modal" data-target="#zoomModal">
											<span class="fa-stack fa-lg">
												<i class="fas fa-circle fa-stack-2x"></i>
												<i class="fas fa-video fa-sm fa-stack-1x fa-inverse"></i>
											</span>
										</button>
									</td>
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

		{{--  MESSAGE PANEL  --}}
		<div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-body">
					<h5>Mensajes</h5>
					{{--  UNREAD CHATS  --}}
					@foreach ($chats as $chat)
						@php
							if ($chat->user1 === $teacher->id) {
								$otherUser = $chat->getUser($chat->user2);
							} else {
								$otherUser = $chat->getUser($chat->user1);
							}
							$unreadgo = 1;
							$unreadMessages = 0;
							foreach ($chat->chatMessages as $cmw) {
								if ($cmw->user_id !== $teacher->id && $cmw->status === 0) {
									$unreadMessages++;
								}else {
									$unreadgo = 0;
								}
							}
						@endphp
						@if ($unreadgo && count($chat->chatMessages) > 0)
							<div class="row align-items-center mb-4">
								{{--  PROFILE PIC  --}}
								<div class="col-2">
									<span class="fa-stack fa-lg">
										@if ($otherUser->perfil)
											<img src="{{ asset($otherUser->perfil) }}" class="mid-img">	
										@else
											<i class="fas fa-circle fa-stack-2x text-light"></i>
											<i class="fas fa-user fa-stack-1x fa-sm text-secondary"></i>
										@endif
									</span>
								</div>

								{{--  NAME  --}}
								<div class="col-8 align-self-center text-center">
									<a href="javascript:void(0);" id="{{ $chat->id.'_'.$otherUser->id }}" class="chatModalBtn" data-toggle="modal" data-target="#chatModal">
										<h6 class="m-0"><b>{{ $otherUser->name }}</b></h6>
									</a>
								</div>

								{{--  PENDING MESSAGES  --}}
								<div class="col align-self-center text-right">
									@if ($unreadMessages > 0)
										<span class="badge badge-danger">{{ $unreadMessages }}</span>
									@else
										<span class="badge badge-primary">{{ count($chat->chatMessages) }}</span>
									@endif	
								</div>
								
							</div>
						@endif
					@endforeach

					{{--  READ CHATS  --}}
					@forelse ($chats as $chat)
						@php
							if ($chat->user1 === $teacher->id) {
								$otherUser = $chat->getUser($chat->user2);
							} else {
								$otherUser = $chat->getUser($chat->user1);
							}
							$unreadgo = 1;
							$unreadMessages = 0;
							foreach ($chat->chatMessages as $cmw) {
								if ($cmw->user_id !== $teacher->id && $cmw->status === 0) {
									$unreadMessages++;
								}else {
									$unreadgo = 0;
								}
							}
						@endphp
						@if (!$unreadgo && count($chat->chatMessages) > 0)
							<div class="row align-items-center mb-4">
								{{--  PROFILE PIC  --}}
								<div class="col-2">
									<span class="fa-stack fa-lg">
										@if ($otherUser->perfil)
											<img src="{{ asset($otherUser->perfil) }}" class="mid-img">	
										@else
											<i class="fas fa-circle fa-stack-2x text-light"></i>
											<i class="fas fa-user fa-stack-1x fa-sm text-secondary"></i>
										@endif
									</span>
								</div>

								{{--  NAME  --}}
								<div class="col-8 align-self-center text-center">
									<a href="javascript:void(0);" id="{{ $chat->id.'_'.$otherUser->id }}" class="chatModalBtn" data-toggle="modal" data-target="#chatModal">
										<h6 class="m-0"><b>{{ $otherUser->name }}</b></h6>
									</a>
								</div>

								{{--  PENDING MESSAGES  --}}
								<div class="col align-self-center text-right">
									@if ($unreadMessages > 0)
										<span class="badge badge-danger">{{ $unreadMessages }}</span>
									@else
										<span class="badge badge-primary">{{ count($chat->chatMessages) }}</span>
									@endif	
								</div>
								
							</div>
						@endif
					@empty
						Sin Chats
					@endforelse
					
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Zoom Modal -->
<div class="modal fade" id="zoomModal" tabindex="-1">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title">Zoom - <span id="classNameCont"></span></h5>
		  <button type="button" class="close" data-dismiss="modal">
			<span>&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form action="{{ route('monitor.setZlink') }}" method="POST">
			@csrf
			<input type="hidden" id="claseID" name="claseID">
			{{--  LINK  --}}
			<div class="form-group">
			  <input type="text" class="form-control" id="zlink" name="zlink" placeholder="LINK">
			</div>
			<button type="submit" class="btn btn-primary float-right">Guardar</button>
			<a href="javascript:void(0);" class="btn btn-danger float-right mr-1" id="zoomBtn" target="_blank">
				<i class="fas fa-video" data-toggle="tooltip" data-placement="top" title="Abrir Zoom"></i>
			</a>
		</form>
		</div>
	  </div>
	</div>
</div>

<!-- Chat Modal -->
<div class="modal fade" id="chatModal" tabindex="-1">
	@if(session('chatGo'))
	@php
		$oldChat = App\Models\Chat::findOrFail(session('chatGo'));
		if ($teacher->id === $oldChat->user1) {
			$recieverUser = App\Models\User::findOrFail($oldChat->user2);
		} else {
			$recieverUser = App\Models\User::findOrFail($oldChat->user1);
		}
		// dd($oldChat);
	@endphp
	@endif
	<div class="modal-dialog modal-dialog-scrollable">
	  <div class="modal-content">
		<div class="modal-header">
            <span class="fa-stack fa-lg mr-2" id="profCont">
				
                @if (session('chatGo') && $recieverUser->perfil)
                    <img src="{{ asset($recieverUser->perfil) }}" class="mini-img">	
                @else
                    <i class="fas fa-circle fa-stack-2x text-light"></i>
                    <i class="fas fa-user fa-stack-1x fa-sm text-secondary"></i>
                @endif
            </span>
            <h4 class="modal-title" id="nameCont" >@if(session('chatGo')) {{ $recieverUser->name }} @endif</h4>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
		</div>
		<div class="modal-body">
            <div id="messageCont">
				@if(session('chatGo'))
					@forelse ($oldChat->chatMessages->sortBy('created_at', SORT_REGULAR, true) as $cm)
						@if ($cm->user_id === $teacher->id)
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
				@endif
			</div>
		</div>
	  </div>
	</div>
</div>

{{--  ALERTS  --}}
@if(session('status'))
	@if (session('eStatus') === null)
		<x-success-alert :message="session('status')"/>
	@else
		@if (session('eStatus') === 1)
			<x-success-alert :message="session('status')"/>
		@else
			<x-error-alert :message="session('status')"/>	
		@endif
	@endif
@endif
@isset($status)
	@if ($eStatus === null)
		<x-success-alert :message="$status"/>
	@else
		@if ($eStatus)
			<x-success-alert :message="$status"/>
		@else
			<x-error-alert :message="$status"/>
		@endif
	@endif
@endisset

@error('nuevaContraseña')
	<script type="text/javascript">
		$( document ).ready(function() {
		$('#passwordModal').modal('show');
	});
	</script>
@enderror

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
<script src="{{ asset('js/ajax/teacherMonitorSwitcher.js') }}" ></script>
@endsection