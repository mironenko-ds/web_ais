<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">

   <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap&subset=cyrillic"
   rel="stylesheet">

   <title> @yield('title') </title>
 </head>
<body>
    @include('user.layout.sidebar')
    <main class="main">
        @include('user.layout.header')
        <div class="page">
            @yield('content')
        </div>
    </main>
    @hasSection('scriptUser')
        @yield('scriptUser')
    @endif
    <script src="{{ asset('js/app.min.js') }}" defer></script>
</body>
