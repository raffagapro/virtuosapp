<nav class="navbar navbar-light sub-bar">
    <div class="container-fluid">
        <nav class="mx-auto">
            <ol class="breadcrumb sub-bar-item mb-0">
              <li class="breadcrumb-item"><a class="sub-bar-item" href="{{ url('/') }}"><i class="fas fa-home mr-2"></i>Dashboard</a></li>
              @php
                  $totalN = count($crumbs);
              @endphp
              @foreach ($crumbs as $key => $value )
                @php
                    $totalN--;
                @endphp
                @if ($totalN === 0)
                    <li class="breadcrumb-item active">{{ $key }}</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route($value) }}">{{ $key }}</a></li>
                @endif
              @endforeach
            </ol>
        </nav>
    </div>
  </nav>