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
                <form method="GET" action="">
                <label for="sort">
                    <p>Сортування</p>
                    @if (!empty($get_req))
                        <select name="value" id="sort">
                            <option value="1"
                            {{$get_req['val'] == 1 ? 'selected' : null}}
                            >назва роботи</option>
                            <option value="2"
                            {{$get_req['val'] == 2 ? 'selected' : null}}
                            >дата створення</option>
                            <option value="3"
                            {{$get_req['val'] == 3 ? 'selected' : null}}
                            >частка за планом</option>
                            <option value="4"
                            {{$get_req['val'] == 4 ? 'selected' : null}}
                            >частка за фактом</option>
                        </select>
                    @else
                    <select name="value" id="sort">
                        <option value="1">назва роботи</option>
                        <option value="2">дата створення</option>
                        <option value="3">частка за планом</option>
                        <option value="4">частка за фактом</option>
                        {{-- <option value="3">частка за планом</option> --}}
                    </select>
                    @endif
                </label>
            </div>
            <div class="header-item">
                <label for="sort">
                    <p>Як</p>
                    @if (!empty($get_req))
                        <select name="type-sort" id="type-sort">
                            <option {{$get_req['type'] == 'desc' ? 'selected' : null}}
                            value="desc">по спаданню</option>
                            <option {{$get_req['type'] == 'asc' ? 'selected' : null}}
                            value="asc">по зростанню</option>
                        </select>
                    @else
                    <select name="type-sort" id="type-sort">
                        <option value="desc">по спаданню</option>
                        <option value="asc">по зростанню</option>
                    </select>
                    @endif
                </label>
        </div>
            <div class="header-item">
                    <button type="submit" class="btn-submit-input">Оновити</button>
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
                <th style="min-width: 90px;">
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
                        @if ($work->status)
                            <div class="status-ok">
                                <p>схвалено</p>
                            </div>
                        @else
                        <div class="status-pend">
                            <p>в обробці</p>
                        </div>
                        @endif
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
        {{ $works->appends(request()->query())->onEachSide(2)->links() }}
    </div>
    @endisset
    </div>
@endsection
