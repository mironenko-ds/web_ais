
<header class="header">
    <div class="head-title">
        <div class="head-title">
            <h1>Панель Адміністратора</h1>
        </div>
    </div>
    <div class="head-items">
        <div class="head__logo-user">
                <img src="{{ asset('img/admin.png') }}" alt="">
            <div class="user__menu dis-hide">
                <div class="item-user">
                <a href="{{ route('admin.account') }}">Аккаунт</a>
                </div>
                <div class="item-user" style="border: none;">
                   <a href="#"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();"
                   >Вихід</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</header>
