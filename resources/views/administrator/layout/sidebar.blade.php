<div class="sidebar show">
    <div class="logo">
        <a href="{{ route('admin.index') }}">
            <img src="{{ asset('img/logo.png') }}" alt="logo">
        </a>
    </div>
    <menu class="menu">
        <div class="btn-hide">
            <img src="{{ asset('img/hide.png') }}" alt="btn-hide">
        </div>
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
                    <p>Управління</p>
                </a>
            </li>
        </ul>
    </menu>
</div>
