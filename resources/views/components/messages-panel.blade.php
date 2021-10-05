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
<x-chat-Modal :user="$user" :monitor="$monitor"/>