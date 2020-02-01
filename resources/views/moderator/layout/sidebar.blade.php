<div class="sidebar show">
    <div class="logo">
        <a href="{{ route('moderator.index') }}">
            <img src="{{ asset('img/logo.png') }}" alt="logo">
        </a>
    </div>
    <menu class="menu">
        <div class="btn-hide">
            <img src="{{ asset('img/hide.png') }}" alt="btn-hide">
        </div>
        <ul>
            <li>
                <a href="{{ route('moderator.employees') }}">
                    <img src="{{ asset('img/users.png') }}" alt="employees">
                    <p>Співробітники кафедри</p>
                </a>
            </li>
            <li>
                <a href="{{ route('moderator.addUser') }}">
                    <img src="{{ asset('img/user-new.png') }}" alt="register">
                    <p>Запити на реєстрацію</p>
                </a>
            </li>
            <li>
                <a href="{{ route('moderator.usersQuestion') }}">
                    <img src="{{ asset('img/questions.png') }}" alt="feedback">
                    <p>Питання від користувачів</p>
                </a>
            </li>
            <li>
                <a href="{{ route('moderator.works') }}">
                    <img src="{{asset('img/icon2.png') }}" alt="my_work">
                    <p>Публікації по кафедрі</p>
                </a>
            </li>
            <li>
                <a href="{{ route('moderator.feedback') }}">
                    <img src="{{ asset('img/icon3.png') }}" alt="feedback_go">
                    <p>Зв'язок з адміністратором</p>
                </a>
            </li>
        </ul>
    </menu>
</div>
