<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">

</head>
<body class="login">
  <div class="form-login">
      <div class="header">
          <h3>Вход в систему</h3>
      </div>
      <form method="POST" action="{{ route('login') }}" class="body">
        @csrf
          <input class="form-control" type="login" name="email" laceholder="Логин" required="required">
          <input class="form-control" type="password" name="password" placeholder="Пароль" required="required">
          <label>
              <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
              Запомнить пароль
          </label>
            @foreach ($errors->all() as $error)
                <strong>{{ $error }}</strong>
            @endforeach
          <input type="submit" value="Войти">
      </form>
      @if (Route::has('password.request'))
          <a class="btn btn-link" href="{{ route('password.request') }}">
              Забыли свой пароль?
          </a>
      @endif
      <div class="links">
      <a href="{{ route('new.user') }}">
              Подать заявку на регистрацию
          </a>
      </div>
  </div>
</body>

</html>
