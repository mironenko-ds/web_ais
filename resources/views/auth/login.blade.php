<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="{{ asset('js/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Вход в систему</div>
      <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                    @csrf
          <div class="form-group">
            <div class="form-label-group">
              <input style="animation: none;" type="email" name="email" id="inputLogin" class="form-control" placeholder="Логин" required="required" value="{{ old('email') }}" required autocomplete="email" autofocus>
              <label for="inputLogin">Логин</label>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="inputPassword" class="form-control" placeholder="Пароль" name="password" required autocomplete="current-password">
              <label for="inputPassword">Пароль</label>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                Запомнить пароль
              </label>
            </div>
          </div>
          <div class="form-group" style="display: flex;
          justify-content: center;
          flex-direction: column;
          align-items: center;">
            <div class="col-md-4">
                <button type="submit" style="width: 100%;" class="btn btn-primary">
                    Вход
                </button>
            </div>
        </div>
        </form>
        <div class="form-group" style="display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 0;">
                <div class="pass-req">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Забыли свой пароль?
                        </a>
                    @endif
                </div>
                <div>
                    <a class="d-block small" href="registerRequest.html">Подать заявку на регистрацию</a>
                </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('js/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('js/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('js/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

</body>

</html>
