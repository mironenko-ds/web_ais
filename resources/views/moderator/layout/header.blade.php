
<header class="header">
    <div class="head-title">
        <div class="head-title">
            <h1>{{ Auth::user()->employee->departament->departament_name }}</h1>
        </div>
    </div>
    <div class="head-items">
        <div class="head__message">
            @php
                $count = App\Models\FeedbackAnser::where(
                    [['asked_user', '=', Auth::user()->id],
                     ['asked_user_read', '=', false]]
                    )->count();
            @endphp
            @if ( $count == 0 )
            @elseif($count <= 9)
                <div class="message-title"><span>{{ $count }}</span></div>
            @elseif($count >= 9)
                <div class="message-title"><span>9+</span></div>
            @endif
            <a href="{{ route('moderator.myMessage') }}">
                <img src="{{ asset('img/message.png') }}" alt="">
            </a>
        </div>
        <div class="head__logo-user">
                <img src="{{ asset('img/moderator-logo.png') }}" alt="">
            <div class="user__menu dis-hide">
                <div class="item-user">
                <a href="{{ route('moderator.account') }}">Аккаунт</a>
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
