@extends('user.layout.template')
@section('title', 'Мой аккаут')
@section('content')
<div class="page__title">
    <a href="{{ route('user.index') }}">Главная</a>
    <img src="{{ asset('img/next.png') }}" alt="">
    <a href="{{ route('user.account') }}">Аккаунт</a>
</div>
<div class="user-info block">
    <div class="child-item">
        <div class="title-edit">
            <h1>
                Общая информация
            </h1>
        </div>
        <div class="wrapped-child">
            <div class="user-group">
                <label for="userName">
                    <input type="text" readonly name="" id="userName" class="text-input" value="{{ $userName }}">
                    <p>Имя</p>
                </label>
                <label for="userSurname">
                    <input type="text" readonly name="" id="userSurname" class="text-input" value="{{ $surName }}">
                    <p>Фамилия</p>
                </label>
                <label for="userPatronymic">
                    <input type="text" value="ggffff" readonly name="" id="userPatronymic" class="text-input" value="{{ $patronymic }}">
                    <p>Отчество</p>
                </label>
            </div>
        </div>
    </div>

    <div class="child-item">
        <div class="title-edit">
            <h1>
                Информация об аккаунте
            </h1>
        </div>
        <div class="wrapped-child">
            <form action="{{ route('user.resetEmail') }}" method="POST">
                @csrf
                <div class="user-group">
                    <label for="userEmail">
                        <input type="email" disabled="true" id="userEmail" class="text-input" value="{{ $email }}">
                        <p>Почта</p>
                    </label>
                    <label for="userNewEmail">
                        <input type="email" required name="new-email" id="userNewEmail" class="text-input">
                        <p>Новая почта</p>
                    </label>
                    <button type="submit" class="btn-submit-input">Обновить</button>

                    @if (session('successEmail'))
                        <div class="email-reset">
                            {{ session()->get('successEmail') }}
                        </div>
                    @endif
                    @if (session('errorReset'))
                        <div class="email-error">
                            {{ session()->get('errorReset') }}
                        </div>
                    @endif

                    <ul>
                    @error('new-email')
                        <div class="email-error">{{ $message }}</div>
                    @enderror
                    </ul>
                </div>
            </form>
        </div>
    </div>
    <!-- </div> -->

    <div class="child-item">
        <div class="title-edit">
            <h1>
                Информация о преподавателе
            </h1>
        </div>
        <div class="wrapped-child">
            <div class="user-detals">
                <label for="userFaculty">
                    <input type="text" disabled="true" name="" id="userFaculty" class="text-input"value="{{ $facultyName }}">
                    <p>Факультет</p>
                </label>
                <label for="userDepartament">
                    <input type="text" disabled="true" name="" id="userDepartament" class="text-input"value="{{$departamentName}}">
                    <p>Кафедра</p>
                </label>
                <label for="userAcademicDegree">
                    <input type="text" disabled="true" name="" id="userAcademicDegree" class="text-input"value="{{$degreeName}}">
                    <p>Ученая степень</p>
                </label>
                <label for="userType">
                    <input type="text" disabled="true" name="" id="userType" class="text-input" value="{{$userPost}}">
                    <p>Должность</p>
                </label>
            </div>
        </div>
    </div>
    <!--  -->
    <div class="child-item">
        <div class="title-edit">
            <h1>
                Сменить пароль
            </h1>
        </div>
        <div class="wrapped-child">
            <form action="{{ route('user.resetPass') }}" method="POST">
                @csrf
                <div class="user-group">
                    <label for="userOldPassword">
                        <input type="password" required name="old-password"
                            id="userOldPassword" class="text-input">
                        <p>Текущий пароль</p>
                    </label>
                    <label for="userNewPassword">
                        <input type="password" required name="new-password" id="userNewPassword"
                            class="text-input" pattern="{8,}">
                        <p>Новый пароль</p>
                    </label>
                    <label for="userNewPasswordReplay">
                        <input type="password" required name="replay-password" id="userNewPasswordReplay"
                            class="text-input" pattern="{8,}">
                        <p>Повторите пароль</p>
                    </label>
                    <button type="submit" class="btn-submit-input">Обновить</button>

                    @if (session('successPass'))
                        <div class="email-reset">
                            {{ session()->get('successPass') }}
                        </div>
                    @endif
                    @if (session('errorPass'))
                        <div class="email-error">
                            {{ session()->get('errorPass') }}
                        </div>
                    @endif
                    <ul>
                        @error('new-password')
                            <div class="email-error">{{ $message }}</div>
                        @enderror
                    </ul>
                </div>
            </form>
        </div>
    </div>
    <div class="child-item">
        <div class="title-edit">
            <h1>
                <a id="showFormDeleteAccount" href="#">Удалить аккаунт</a>
            </h1>
        </div>
        @if (session('successSend'))
            <div class="send-message">
                {{ session()->get('successSend') }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('in-body')
    <div class="wrapped-form-delete">
        <div class="form-delete">
            <div class="exit">
                <img class="hendler-close" src={{ asset('img/window-close.png') }} alt="close">
            </div>
            <form action="{{ route('user.sendMessange') }}" method="POST">
                @csrf
                <label for="contentCause">
                    <textarea required name="content-message" id="contentCause" class="text-input"></textarea>
                    <p>Причина удаления</p>
                </label>
                <button type="submit">Отправить</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script defer>
        var showForm = document.getElementById("showFormDeleteAccount");
        showForm.addEventListener("click", function (event) {
            event.preventDefault();
            FormDeleteAccount(".wrapped-form-delete", ".hendler-close");
        });
    </script>
@endsection
