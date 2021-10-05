<div class="modal fade" id="chatModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-scrollable">
	  <div class="modal-content">
		<div class="modal-header">
            {{--  PROFILE PHOTO  --}}
            <span class="fa-stack fa-lg mr-2" id="profCont">
                @isset($recieverUser)
                    @if ($recieverUser->perfil)
                        <img src="{{ asset($recieverUser->perfil) }}" class="mini-img">	
                    @else
                        <i class="fas fa-circle fa-stack-2x text-light"></i>
                        <i class="fas fa-user fa-stack-1x fa-sm text-secondary"></i>
                    @endif
                @endisset
            </span>
            <h4 class="modal-title" id="nameCont" >@isset($recieverUser) {{ $recieverUser->name }} @endisset</h4>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
		</div>
		<div class="modal-body">
            <div id="messageCont">
				@isset($recieverUser)
					@forelse ($chat->chatMessages->sortBy('created_at', SORT_REGULAR, true) as $cm)
						@if ($cm->user_id === $user->id)
							<div class="row mr-2">
								<div class="col-2"></div>
								<div class="alert alert-light col" role="alert">
									<p>{{ $cm->body }}</p>
									<hr class="m-1">
									<small class="mb-0 text-right text-small">{{ $cm->dateParser() }}</small>
								</div>
							</div>
						@else
							<div class="row ml-2">
								<div class="alert alert-info col-10" role="alert">
									<p>{{ $cm->body }}</p>
									<hr class="m-1">
									<div class="row justify-content-end">
										<small class="mb-0 mr-3">{{ $cm->dateParser() }}</small>
									</div>
								</div>
							</div>
						@endif
					@empty
						<p class="text-muted">Sin mensajes registrados...</p>
					@endforelse
                @endisset
			</div>
		</div>
        @if (!$monitor)
            <div class="modal-footer">
                {{--  SEND MESSAGE FORM  --}}
                @if ($user->role->name === "Estudiante")
                    <form action="{{ route('chatStudent.store') }}" method="POST" class="m-auto w-100">
                @else
                    <form action="{{ route('chatTeacher.store') }}" method="POST" class="m-auto w-100">
                @endif
                    @csrf
                    <input type="hidden" name="senderId" id="senderId" value="{{ $user->id }}">
                    @if ($user->role->name === "Estudiante")
                        <input type="hidden" name="recieverId" id="recieverId" value="{{ $recieverUser->id }}">
                        @if ($chat)
                            <input type="hidden" name="chatId" id="chatId" value="{{ $chat->id }}"> 
                        @endif
                    @else
                        <input type="hidden" name="chatId" id="chatId" @if(session('chatGo')) value="{{ $chat->id }}" @endif>     
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
        @endif
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