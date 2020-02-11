<div class="sidebar show">
    <div class="logo">
        <a href="{{ route('admin.index') }}" class="project-logo">
            <img src="{{ asset('img/logo.png') }}" alt="logo">
        </a>
    </div>
    <div class="btn-hide">
        <img src="{{ asset('img/hide.png') }}" alt="btn-hide">
    </div>
    <menu class="menu">
        <ul>
            <li>
                <a href="{{ route('admin.users') }}">
                    <img src="{{ asset('img/users.png') }}" alt="employees">
                    <p>Користувачі</p>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.questions') }}">
                    <img src="{{ asset('img/questions.png') }}" alt="feedback">
                    <p>Питання від користувачів</p>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.management') }}">
                    <img src="{{asset('img/setting.png') }}" alt="my_work">
                    <p>Управління факультетами</p>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.degreeShow') }}">
                    <img src="{{asset('img/academic-degree.png') }}" alt="my_work">
                    <p>Наукові ступені</p>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.postShow') }}">
                    <img src="{{asset('img/user-logo.png') }}" alt="my_work">
                    <p>Посади</p>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.typeWorkShow') }}">
                    <img src="{{asset('img/icon2.png') }}" alt="my_work">
                    <p>Роботи</p>
                </a>
            </li>
        </ul>
    </menu>
    <menu class="mini-menu">
        <div class="wrapped-menu-menu">
            <ul>
                <li>
                    <a href="{{ route('admin.users') }}">
                        <img src="{{ asset('img/users.png') }}" alt="employees">
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.questions') }}">
                        <img src="{{ asset('img/questions.png') }}" alt="feedback">
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.management') }}">
                        <img src="{{asset('img/setting.png') }}" alt="my_work">
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.degreeShow') }}">
                        <img src="{{asset('img/academic-degree.png') }}" alt="my_work">
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.postShow') }}">
                        <img src="{{asset('img/user-logo.png') }}" alt="my_work">
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.typeWorkShow') }}">
                        <img src="{{asset('img/icon2.png') }}" alt="my_work">
                    </a>
                </li>
            </ul>
    </div>
    </menu>
</div>
