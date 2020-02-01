@extends('moderator.layout.template')
@section('title', 'Запити на додавання роботи')
@section('content')
    <div class="page__title">
        <a href="{{ route('moderator.index') }}">Головна</a>
        <img src="{{ asset('img/next.png') }}" alt="next">
        <a href="{{ route('moderator.requestWork') }}">Запити на додавання роботи</a>
    </div>
    <div class="user_offer block">
        Запити на додавання роботи
    </div>
@endsection
@section('scriptUser')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" defer></script>
    <script src="{{ asset('js/graph.min.js') }}" defer></script>
@endsection
