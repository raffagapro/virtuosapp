<div class="card bgVirtuos-docente border-secondary text-center py-5">
    <div class="card-body">
        {{--  PROFILE PHOTO  --}}
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
            @if ($unreadMessages > 0)
                <span class="badge badge-danger float-right" style="margin-left:-150px">{{ $unreadMessages }}</span>
            @endif
        </a>
    </div>
</div>

<!-- Chat Modal -->
<x-chat-Modal :user="$user" :monitor="$monitor" :recieverUser="$clase->teacher()" :chat="$foundChat"/>
