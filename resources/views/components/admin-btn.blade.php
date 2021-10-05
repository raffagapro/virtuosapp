<div class="col-6">
    <a class="btn d-block btn-light border-secondary btn-text-start @if (!$routex) disabled @endif"
        @if ($routex)
            href="{{ route($routex) }}"
        @endif
    >
        <div class="card-body row px-5">
            <h4 class="my-auto">{{ $title }}</h4>
            <img class="ml-auto panel-btn-icon" src="{{ asset($iconURL) }}" alt="">
        </div>
    </a>
</div>