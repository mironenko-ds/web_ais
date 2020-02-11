@extends('user.layout.template')
@section('title', 'Головна сторінка')
@section('content')
    <div class="page__title">
        <a href="#">Головна</a>
    </div>
    <div class="user_offer block">
        <h1>Общая информация</h1>
        <p>
            Добро пожаловать в систему учета научных публикаций преподавателей. Вы можете просмотреть свои публикации, подать заявки на добавление новых и связаться с модератором
        </p>
    </div>
    <div class="user_offer block">
    <canvas id="myChart" style="height: 500px"></canvas>
    </div>
@endsection
@section('scriptUser')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" defer></script>
    <script src="{{ asset('js/graph.min.js') }}" defer></script>
@endsection
