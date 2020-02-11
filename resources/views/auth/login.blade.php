<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Вхід у систему</title>

    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">

    <link rel="shortcut icon" href="{{ asset('img/icon.ico') }}" type="image/x-icon">

</head>
<body class="login">
  <div class="form-login">
      <div class="header">
          <h3>Вхід у систему</h3>
      </div>
      <form method="POST" action="{{ route('login') }}" class="body">
        @csrf
          <input class="form-control" type="login" name="email" placeholder="Логін" required="required">
          <input class="form-control" type="password" name="password" placeholder="Пароль" required="required">
          <label>
              <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
              Запам'ятати пароль
          </label>
            @foreach ($errors->all() as $error)
                <div class="message-error">
                    <strong>{{ $error }}</strong>
                </div>
            @endforeach
          <input type="submit" value="Увійти">
      </form>
      <div class="links">
      @if (Route::has('password.request'))
          <a class="btn btn-link" href="{{ route('password.request') }}">
            Забули пароль?
          </a>
      @endif
      <a href="{{ route('new.user') }}" style="background-color:#2d2d2d;">
        Заявка на реєстрацію
      </a>
    </div>
  </div>
</body>

</html>
