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
                    @if (isset($value[1]))
                        <li class="breadcrumb-item"><a href="{{ route($value[0], $value[1]) }}">{{ $key }}</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route($value[0]) }}">{{ $key }}</a></li>
                    @endif
                @endif
              @endforeach
            </ol>
        </nav>
    </div>
  </nav>