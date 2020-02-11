@extends('administrator.layout.template')
@section('title', 'Головна сторінка')
@section('content')
    <div class="page__title">
        <a href="#">Головна</a>
    </div>
    <div class="user_offer block">
        @if (isset($facultes))
            <div class="wrapped-faculty">
                @foreach ($facultes as $faculty)
                <a href="{{ route('admin.faculty', $faculty->id) }}">
                    <div class="faculty-item">
                        <div class="faculty-name">
                            <h2>{{ $faculty->faculty_name }}</h2>
                        </div>
                        <div class="faculty-dep">
                           @if ($faculty->departament_count != 0)
                           Кількість кафедр {{ $faculty->departament_count }}
                           @else
                           кафедри відсутні
                           @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        @else
            <div class="no-faculty">
                <h1>
                    Факультети відсутні
                </h1>
            </div>
        @endif
    </div>
@endsection
@section('scriptUser')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" defer></script>
    <script src="{{ asset('js/graph.min.js') }}" defer></script>
@endsection
