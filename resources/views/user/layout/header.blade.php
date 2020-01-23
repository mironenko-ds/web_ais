
<header class="header">
    <div class="head-title">
        @if (Auth::user()->role != 'admin')
        <div class="head-title">
            <h1>{{ Auth::user()->employee->departament->departament_name }}</h1>
        </div>
        @else
        <div class="head-title">
            <h1>Панель администратора</h1>
        </div>
        @endif
    </div>
    <div class="head-items">
        <div class="head__message">
            <div class="message-title"><span>12...</span></div>
            <a href="#">
                <img src="{{ asset('img/message.png') }}" alt="">
            </a>
        </div>
        <div class="head__logo-user">
                <img src="{{ asset('img/user-logo.png') }}" alt="">
            <div class="user__menu dis-hide">
                <div class="item-user">
                <a href="{{ route('user.account') }}">Аккаунт</a>
                </div>
                <div class="item-user" style="border: none;">
                   <a href="#"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();"
                   >Выход</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</header>
