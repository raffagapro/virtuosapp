<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <main class="py-5">
            <div class="container-fluid">
                <div class="col-md-10 col-lg-8 card mx-auto my-5 bgVirtuos border-0 shadow-lg" style="max-height: 590px"  style="">
                    <div class="row">
                        <div class="col-4 d-none d-sm-block p-0">
                            <img class="card-img-left img-fluid" style="max-height: 590px" src="assets\images\group43.png" alt="">
                        </div>
                        <div class="card-body col-sm-8 py-4">
                            <div class="row">
                                <img class="mx-auto my-4" style="max-width: 50%" src="assets\images\login_brand.png" alt="">
                            </div>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
            
                                    <div class="form-group row my-2">            
                                        <div class="col-md-8  input-group mx-auto px-0">
                                            <label for="username" class="input-group-text login-input-pill rounded-pill-start"><i class="fas fa-user"></i></label>
                                            <input id="username" type="text" class="form-control login-input-pill rounded-pill-end @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="Usuario" autofocus>
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row">            
                                        <div class="col-md-8 input-group mx-auto px-0">
                                            <label for="password" class="input-group-text login-input-pill rounded-pill-start"><i class="fas fa-lock"></i></label>
                                            <input id="password" type="password" class="form-control login-input-pill rounded-pill-end @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row mb-2">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" checked hidden type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            
                                                <label class="form-check-label" hidden for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="form-group row mb-0">
                                        <button type="submit" class="col-md-8 btn btn-danger rounded-pill mx-auto">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                    @if (Route::has('password.request'))
                                    <div class="form-group row mb-0">
                                        <a class="col-md-8 btn btn-link text-light mx-auto" href="{{ route('password.request') }}">
                                            ¿Olvidaste tu contraseña?
                                        </a>
                                    </div>
                                    @endif
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
