@extends('user.layout.template')
@section('title', 'Мой аккаут')
@section('content')
<div class="page__title">
    <a href="#">Главная</a>
    <img src="{{ asset('img/next.png') }}" alt="">
    <a href="#">Аккаунт</a>
</div>
<div class="user-info block">
    <div class="title-edit">
        <h1>
            Личная информация
        </h1>
        <img src="{{ asset('img/edit.png') }}" alt="">
    </div>
    <form>
        <div class="group-text">
        <input type="text" placeholder="Фамилия" class="text-input" value="{{ $user->employee->surname }}">
            <input type="text" placeholder="Имя" class="text-input" value="{{ $user->employee->name }}">
            <input type="text" placeholder="Отчество" class="text-input" value="{{ $user->employee->patronymic }}">
        </div>
        <div class="group-text">
            <input type="text" placeholder="Почта" class="text-input" value="{{ $user->email }}">
            <input type="text" placeholder="Старый пароль" class="text-input">
            <input type="text" placeholder="Новый пароль" class="text-input">
        </div>
        <div class="submit">
            <input type="submit" class="btn-submit-input" value="Обновить">
        </div>
    </form>
</div>

<div class="user-info block">
    <div class="title-edit">
        <h1>
            Информация о преподавателе
        </h1>
        <img src="{{ asset('img/no-edit.png') }}" alt="">
    </div>
    <div class="group-text">
        <input type="text" placeholder="Должность" disabled="true" class="text-input" value="{{$user->employee->post->post_name}}">
        <input type="text" placeholder="Ученая степень" disabled="true" class="text-input" value="{{$user->employee->degree->degree_name}}">
       <div class="width-max">
        <input type="text" placeholder="Факультет" class="text-input" disabled="true" value="{{ $user->employee->departament->faculty->faculty_name }}">
        <input type="text" placeholder="Кафедра" class="text-input" disabled="true" value="{{$user->employee->departament->departament_name}}">
       </div>
    </div>
</div>
@endsection
