<div class="sidebar show">
    <div class="logo">
        <a href="/">
            <img src="{{ asset('img/logo.png') }}" alt="1">
        </a>
    </div>
    <menu class="menu">
        <div class="btn-hide">
            <img src="{{ asset('img/hide.png') }}" alt="1">
        </div>
        <ul>
            <li>
            <a href="{{ route('user.addWork') }}">
                    <img src="{{ asset('img/icon1.png') }}" alt="1">
                    <p>Разместить публикацию</p>
                </a>
            </li>
            <li>
            <a href="{{ route('user.works') }}">
                    <img src="{{ asset('img/icon2.png') }}" alt="1">
                    <p>Мои публикации</p>
                </a>
            </li>
            <li>
            <a href="{{ route('user.feedback') }}">
                    <img src="{{ asset('img/icon3.png') }}" alt="1">
                    <p>Связь с модератором</p>
                </a>
            </li>
        </ul>
    </menu>
</div>
