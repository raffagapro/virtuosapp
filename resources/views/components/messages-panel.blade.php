<div class="card border-secondary">
    <div class="card-body">
        <h5>Mensajes</h5>
        {{--  UNREAD CHATS  --}}
        @foreach ($chats as $chat)
            @php
                if ($chat->user1 === $user->id) {
                    $otherUser = $chat->getUser($chat->user2);
                } else {
                    $otherUser = $chat->getUser($chat->user1);
                }
                $unreadgo = 1;
                $unreadMessages = 0;
                foreach ($chat->chatMessages as $cmw) {
                    if ($cmw->user_id !== $user->id && $cmw->status === 0) {
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
                if ($chat->user1 === $user->id) {
                    $otherUser = $chat->getUser($chat->user2);
                } else {
                    $otherUser = $chat->getUser($chat->user1);
                }
                $unreadgo = 1;
                $unreadMessages = 0;
                foreach ($chat->chatMessages as $cmw) {
                    if ($cmw->user_id !== $user->id && $cmw->status === 0) {
                        $unreadMessages++;
                    }else {
                        $unreadgo = 0;
                    }
                }
                // dd(count($chat->chatMessages));
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

<!-- Chat Modal -->
<div class="modal fade" id="chatModal" tabindex="-1">
	@if(session('chatGo'))
	@php
		$oldChat = App\Models\Chat::findOrFail(session('chatGo'));
		if ($user->id === $oldChat->user1) {
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
						@if ($cm->user_id === $user->id)
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
        @if (!$monitor)
            <div class="modal-footer">
                {{--  SEND MESSAGE FORM  --}}
                <form action="{{ route('chatTeacher.store') }}" method="POST" class="m-auto w-100">
                    @csrf
                    <input type="hidden" name="senderId" id="senderId" value="{{ $user->id }}">
                    <input type="hidden" name="chatId" id="chatId" @if(session('chatGo')) value="{{ $oldChat->id }}" @endif> 
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