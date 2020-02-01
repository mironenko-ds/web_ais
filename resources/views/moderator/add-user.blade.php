@extends('moderator.layout.template')
@section('title', 'Запити на реєстрацію')
@section('content')
<div class="page__title">
    <a href="{{ route('moderator.index') }}">Головна</a>
    <img src="{{ asset('img/next.png') }}" alt="next">
    <a href="{{ route('moderator.addUser') }}">Запити на реєстрацію</a>
</div>
    <div class="user_offer block-no-padding" style="margin-top:30px;">
        @if (isset($request))
        <h1>{{ $request }}</h1>
    @else
    <div class="header">
        <div class="header-item">
                <p>Кількість запитів: {{$req_user->total()}}</p>
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
        </div>
        <div class="wrapped-form">
        <table class="main-table" style="margin-top:20px; width:100%">
            <tr>
                <th>
                    Співробітник
                </th>
                <th>
                    Пошта
                </th>
                <th>
                   Посада
                </th>
                <th>
                    Підтвердити <span title="Після того як ви підтвердите, в систему додасться новий обліковий запис і дані для входу відправляться на пошту користувачеві" style="color:red;">*</span>
                </th>
                <th>
                    Надіслати на виправлення <span title="Вкажіть що потрібно виправити і ваше повідомлення піде на пошту користувачеві" style="color:red;">*</span>
                </th>
            </tr>
            @foreach ($req_user as $user)
                <tr>
                    <td>
                        {{ $user->name . ' ' . $user->surname . ' ' . $user->patronymic }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        {{ $user->pos->post_name }}
                    </td>
                    <td>
                        <form action="{{ route('moderator.userAdd') }}"
                            style="display: flex;justify-content: center;"
                        method="post">
                            @csrf
                            <input type="text" name="user_id_req" hidden value="{{$user->id}}">
                            <img src="{{ asset('img/new-work.png') }}"
                            onclick="
                                var path = event.path || (event.composedPath && event.composedPath());
                                path[1].submit();
                            "
                            alt="delete" style="width:40px;height:40px;cursor:pointer;">
                        </form>
                    </td>
                    <td>
                        <div class="reset" style="cursor: pointer;display:flex;justify-content: center;">
                            <img id="reset" style="cursor:pointer; width:40px; height:40px;" data-user-id="{{ $user->id }}"
                            data-user-name="{{  $user->name . ' ' . $user->surname . ' ' . $user->patronymic  }}"
                             src="{{ asset('img/detail.png') }}" alt="delete">
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        @isset($req_user)
        <div class="wrapped-elements">
            {{ $req_user->onEachSide(2)->links() }}
        </div>
        @endisset
    </div>
        @endif
    </div>
    <div class="overlay"></div>
    <div class="modal-edit" style="">
        <div class="modal-header">
            <img id="close-modal-reset" src="{{ asset('img/delete.png') }}" alt="close">
        </div>
        <form action="{{ route('moderator.noAddUser') }}" method="POST">
            @csrf
            <h3 class="user-name"></h3>
            <input type="text" id="user_req" hidden name="user_req">
            <label for="" style="display: flex;flex-direction: column;">
                <p style="padding-bottom: 7px;font-size: 18px;">
                    Вкажіть що потрібно виправити</p>
                <textarea name="message" style="resize: none;height: 200px;border: 1px solid #508eca;"></textarea>
            </label>
            <div class="group-bb" style="display:flex; justify-content:flex-end;margin-top:10px">
                <button type="submit" class="btn-submit-input">Відправити</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script defer>
        var btns = document.querySelectorAll('#reset');
        var Modal = document.querySelector('.modal-edit');
        var closeModal = document.querySelector('#close-modal-reset');
        var overlay = document.querySelector('.overlay');
        var userName = document.querySelector('.user-name');
        var UserReq = document.querySelector('#user_req');

        overlay.addEventListener('click', function(){
                Modal.classList.remove('show-block');
                overlay.classList.remove('show-block');
        });

        closeModal.addEventListener('click', function(){
                Modal.classList.remove('show-block');
                overlay.classList.remove('show-block');
        });

        btns.forEach(function(item){

            item.addEventListener('click', function(){
                var name = this.getAttribute('data-user-name');
                userName.textContent = name;
                UserReq.setAttribute('value', this.getAttribute('data-user-id'));
                Modal.classList.add('show-block');
                overlay.classList.add('show-block');

            });
        });
    </script>
@endsection
