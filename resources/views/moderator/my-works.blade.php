@extends('moderator.layout.template')
@section('title', 'Публікації по кафедрі')
@section('content')
    <div class="page__title">
        <a href="{{ route('moderator.index') }}">Головна</a>
        <img src="{{ asset('img/next.png') }}" alt="next">
        <a href="{{ route('moderator.works') }}">Публікації по кафедрі</a>
    </div>
    <div class="user-works block-no-padding">
        @if (isset($noWorks))
        <h1>{{ $noWorks }}</h1>
    @else
        <div class="header">
            <div class="header-item">
                <p>Кількість робіт: {{$works->count()}}</p>
            </div>
            <div class="header-item">
                <form action="" method="get">
                    <label for="sort">
                        <p>Сортування</p>
                        <select name="sort" id="sort">
                            <option value="1">Ім'я</option>
                        </select>
                    </label>
            </div>
            <div class="header-item">
                    <label for="sort">
                        <p>Як</p>
                        <select name="type-sort" id="type-sort">
                            <option value="1">по спаданню</option>
                            <option value="2">по зростанню</option>
                        </select>
                    </label>
                </form>
            </div>
            <div class="header-item">
                <a href="{{ route('moderator.addWork') }}">
                    <img title="Натисни щоб додати роботу" src="{{ asset('img/add.png') }}" alt="add"
                    id="addNewUser">
                </a>
            </div>
        </div>
        <table class="main-table" style="margin-top:20px;">
            <tr>
                <th>
                    Назва роботи
                </th>
                <th>
                    Дата створення роботи
                </th>
                <th>
                    Частка за планом [%]
                </th>
                <th>
                    Частка за фактом [%]
                </th>
                <th>
                    Вид праці <span title="Тип виконаної роботи">*</span>
                </th>
                <th>
                    Редагувати
                </th>
                <th>
                    Статус
                </th>
                <th>
                    Видалити
                </th>
            </tr>

            @foreach ($works as $work)
                <tr>
                    <td>
                        {{ $work->title }}
                    </td>
                    <td>
                        {{ $work->created_at->format('m/d/Y') }}
                    </td>
                    <td>
                        {{ $work->percentage_plan }}
                    </td>
                    <td>
                        {{ $work->percentage_fact }}
                    </td>
                    <td>
                        {{ $work->work->indicator }}
                    </td>
                    <td>
                        <div class="edit-bar">
                            <a href="work/{{ $work->id }}">
                                <img data-name-work="{{ $work->title }}" data-modal="edit" src="{{ asset('img/spec-edit.png') }}" alt="edit">
                            </a>
                        </div>
                    </td>
                    <td>
                        <p>{{$work->status ? 'схвалено' : 'в очікуванні схвалення'}}</p>
                    </td>
                    <td>
                        <form id="delete-work" action="{{ route('moderator.deleteWork') }}"
                            style="display: flex;justify-content: center;"
                        method="post">
                            @csrf
                            <input type="text" name="work_id" hidden value="{{$work->id}}">
                            <img src="{{ asset('img/delete-user.png') }}"
                            onclick="event.preventDefault();
                                document.getElementById('delete-work').submit();"
                            alt="delete">
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
    @isset($works)
    <div class="wrapped-elements">
        {{ $works->onEachSide(2)->links() }}
    </div>
    @endisset
    </div>
@endsection
