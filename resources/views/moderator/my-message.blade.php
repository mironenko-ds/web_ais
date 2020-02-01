@extends('moderator.layout.template')
@section('title', 'Мої повідомлення')
@section('content')
    <div class="page__title">
        <a href="{{ route('moderator.index') }}">Головна</a>
        <img src="{{ asset('img/next.png') }}" alt="next">
        <a href="{{ route('moderator.myMessage') }}">Мої повідомлення</a>
    </div>
    <div class="user-message block-no-padding">

        @if (session('errorDeleteAll'))
        <div class="">
            {{ session()->get('errorDeleteAll') }}
        </div>
        @endif
        @if (session('successDeleteAll'))
            <div class="">
                {{ session()->get('successDeleteAll') }}
            </div>
        @endif

        @if (isset($noMessage))
            <h1>{{ $noMessage }}</h1>
        @else
        <div class="header">
            <div class="header-item">
                <p>Загальна кількість повідомлень: {{$answers->total()}}</p>
            </div>
            <div class="header-item">
                <p>Непрочитаних: {{ $count_no_read }}</p>
            </div>
            <div class="header-item">
                <form action="" method="get">
                    <label for="sort">
                        <p>Сортировка</p>
                        <select name="type-sort" id="sort">
                            <option value="1"></option>
                        </select>
                    </label>
                </form>
            </div>
            <div class="header-item">
                <img title="Натисни щоб видалити всі повідомлення" src="{{asset('img/delete-item.png') }}" alt="delete all"
                    id="deleteAll">
            </div>
        </div> <!-- end block header-->
        <div class="wrapped-more-elements">
            @foreach ($answers as $answer)
            <div data-message-id="{{$answer->id}}" class="message-item {{ $answer->asked_user_read ? "read" : "no-read" }}">
                    <div class="header">
                        <div class="close">
                            <img data-title="{{ $answer->feedback->title }}" data-item-id="{{$answer->id}}" id="deleteItemNow" src="{{asset('img/delete.png')}}" alt="close">
                        </div>
                    </div>
                    <div class="body">
                        <h2>
                            <span href="" id="showAllMessage" data-number="1">
                                {{ $answer->feedback->title }}
                            </span>
                        </h2>
                        <p>
                            {{Str::limit($answer->anser, 180)}}
                        </p>
                    </div>
                    <div class="buttom">
                        <p>
                            {{$answer->user_answered->role->role_name}}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        @isset($answers)
            <div class="wrapped-elements" style="padding-right: 15px">
                {{ $answers->onEachSide(2)->links() }}
            </div>
        @endisset
        @endif
    </div>


    <div class="overlay"></div>

    <!-- Show modal all message -->
     @if (!isset($noMessage))
        @foreach ($answers as $item)
            <div style="max-height:95vh;overflow: auto; width:500px;" class="modal" data-api-url="{{ URL::to('/user/change-message') }}" data-csrf={{csrf_token()}} data-item-id="{{ $item->id }}" id="showItem" modal="edit" style="width: 500px;">
                <div class="modal-header">
                    <img style="position:relative; z-index:99;" src="{{ asset('img/delete.png') }}" alt="close">
                </div>
                <div class="modal-body">
                    <h2 class="anser-title">{{ $item->feedback->title }}</h2>
                    <p class="anser-zag">Ответ</p>
                    <textarea class="anser-area text-input">{{ $item->anser }}</textarea>
                    @if ($item->materials)
                        <p class="dop-materials">Додаткові матеріали</p>
                        <table class="main-table form-work">
                            @foreach (json_decode($item->materials) as $material)
                            <tr>
                                <td>
                                <a href="{{ URL::to($material->link) }}">{{ $material->title }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
    <!-- Show modal all message -->

    <!-- Form delete item  -->
            <div class="modal-delete">
                <div class="modal-header">
                    <img id="close-del" src="{{ asset('img/delete.png') }}" alt="close">
                </div>
                <div class="modal-body">
                    <form id="form-del-it" action="{{ route('user.delete-message', ['id' => 0]) }}" method="POST">
                        @csrf
                        <input type="answer_id" name="user_id" hidden value="">
                        <h2>Ви дійсно хочете видалити повідомлення?</h2>
                        <div class="btn-form-group">
                            <input type="submit" value="Да" style="background-color:red;" class="btn-submit-input">
                            <input id="no-delete-item" type="button" value="Нет" class="btn-submit-input">
                        </div>
                    </form>
                </div>
            </div>

    <!-- Form delete item  -->


    <div class="modal-edit" modal="edit">
        <div class="modal-header">
            <img id="close-modal-delete" src="{{ asset('img/delete.png') }}" alt="close">
        </div>
        <div class="modal-body">
            <form action="{{ route('user.deleteAllMessage') }}" method="POST">
                @csrf
                <input type="text" name="user_id" hidden value="{{Auth::user()->id}}">
                <h2>Ви дійсно хочете видалити всі повідомлення?</h2>
                <div class="btn-form-group">
                    <input type="submit" value="Да" style="background-color:red;" class="btn-submit-input">
                    <input id="no-delete" type="button" value="Нет" class="btn-submit-input">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script defer>
        var deleteAll = document.querySelector('#deleteAll');
        var formDeleteAll = document.querySelector('.modal-edit');
        var closeFormDelete = document.querySelector('#close-modal-delete');
        var overlay = document.querySelector(".overlay");
        var noDelete = document.querySelector('#no-delete');

        deleteAll.addEventListener('click', function(){
            formDeleteAll.classList.add('show-block');
            overlay.classList.add('show-block');
        });

        noDelete.addEventListener('click', function(){
            formDeleteAll.classList.remove('show-block');
            overlay.classList.remove('show-block');
        });

        closeFormDelete.addEventListener('click', function(){
            formDeleteAll.classList.remove('show-block');
            overlay.classList.remove('show-block');
        });


        overlay.addEventListener("click", function (event) {
            formDeleteAll.classList.remove('show-block');
            overlay.classList.remove('show-block');
            FormDelete.classList.remove('show-block');
            showItems.forEach(function(item){
                if(item.classList.contains('show-block')){
                    item.classList.remove('show-block');
                }
            });
        });

        var allItems = document.querySelectorAll('.message-item');
        var showItems = document.querySelectorAll('#showItem');


        allItems.forEach(function(itemMain){
            itemMain.addEventListener('click', function(event){
            var path = event.path || (event.composedPath && event.composedPath());
            var clickId = this.getAttribute('data-message-id');

            if(path[1].classList.contains('close')){
                return;
            }

            showItems.forEach(function(item){
                if(item.getAttribute('data-item-id') == clickId){
                    item.classList.add('show-block');
                    overlay.classList.add('show-block');

                    if(itemMain.classList.contains('no-read')){
                        itemMain.classList.remove('no-read');
                        itemMain.classList.add('read');

                        var onRequest = new XMLHttpRequest();
                        onRequest.open("get", item.getAttribute('data-api-url') + '/' + clickId);
                        onRequest.responseType = 'json';
                        onRequest.send();
                        onRequest.onload = function(event){}
                    }
                }
            });
        });
        });

        var deleteOnceAll = document.querySelectorAll('#deleteItemNow');
        var FormDelete = document.querySelector('.modal-delete');
        var closeDeleteItem = document.querySelector('#close-del');
        var noDeleteItem = document.querySelector('#no-delete-item');
        var formDeleteItem = document.querySelector('#form-del-it');

        closeDeleteItem.addEventListener('click', function(){
            FormDelete.classList.remove('show-block');
            overlay.classList.remove('show-block');
        });

        noDeleteItem.addEventListener('click', function(){
            FormDelete.classList.remove('show-block');
            overlay.classList.remove('show-block');
        });

        deleteOnceAll.forEach(function(item){

            item.addEventListener('click', function(){
                var idM = this.getAttribute('data-item-id');
                var link = formDeleteItem.getAttribute('action');
                var newLink = link.substring(0, link.length - 1) + idM;
                formDeleteItem.setAttribute('action', newLink);

                FormDelete.classList.add('show-block');
                overlay.classList.add('show-block');
            });
        });

    </script>
@endsection
