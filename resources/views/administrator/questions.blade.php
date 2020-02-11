@extends('administrator.layout.template')
@section('title', 'Питання від користувачів')
@section('content')
    <div class="page__title">
        <a href="{{ route('admin.index') }}">Головна</a>
        <img src="{{ asset('img/next.png') }}" alt="next">
        <a href="{{ route('admin.questions') }}">Питання від користувачів</a>
    </div>
    <div class="user-works block-no-padding">
        @if (isset($noQuestion))
            <h1>{{ $noQuestion }}</h1>
        @else
        <div class="header">
            <div class="header-item">
                    <p>Кількість питань: {{$questions->total()}}</p>
                </div>
                <div class="header-item">
                    <form id="go-sort" action="" method="get">
                        <label for="sort">
                            <p>Сортування</p>
                            @if (!empty($get_req))
                                <select name="value" id="sort">
                                    <option value="1"
                                    {{$get_req['val'] == 1 ? 'selected' : null}}
                                    >співробітник</option>
                                    <option value="2"
                                    {{$get_req['val'] == 2 ? 'selected' : null}}
                                    >тема</option>
                                </select>
                            @else
                            <select name="value" id="sort">
                                <option value="1">співробітник</option>
                                <option value="2">тема</option>
                            </select>
                            @endif
                        </label>
                </div>
                <div class="header-item">
                    <label for="sort">
                        <p>Як</p>
                        @if (!empty($get_req))
                            <select name="type-sort" id="type-sort">
                                <option {{$get_req['type'] == 'desc' ? 'selected' : null}}
                                value="desc">по спаданню</option>
                                <option {{$get_req['type'] == 'asc' ? 'selected' : null}}
                                value="asc">по зростанню</option>
                            </select>
                        @else
                        <select name="type-sort" id="type-sort">
                            <option value="desc">по спаданню</option>
                            <option value="asc">по зростанню</option>
                        </select>
                        @endif
                    </label>
                </div>
                <div class="header-item">
                    <button type="submit" class="btn-submit-input">Оновити</button>
                </form>
            </div>
            </div>
            <table class="main-table" style="margin-top:20px; width:100%">
                <tr>
                    <th style="width:200px;">
                        Співробітник
                    </th>
                    <th>
                        Тема
                    </th>
                    <th>
                        Питання
                    </th>
                    <th style="width: 60px;">
                        Відповісти
                    </th>
                    <th style="width: 130px;">
                        Дод. матеріали
                    </th>
                </tr>
                @foreach ($questions as $question)
                    <tr>
                        <td>
                            {{ $question->user->employee->name }}
                        </td>
                        <td>
                            {{ $question->title }}
                        </td>
                        <td style="padding: 0; text-align:left;">
                           {{-- <textarea readonly style="width:100%; height:200px; resize:none; border:none;">{{ $question->content }}</textarea> --}}
                           <div data-req-id="{{ $question->id }}" class="show-question">
                            <img src="{{ asset('img/detail.png') }}" alt="add">
                        </div>
                        <div class="modal modal-quest" data-req-id="{{ $question->id }}">
                            <div class="modal-header modal-header-req" data-req-id="{{ $question->id }}">
                                <img  src="{{ asset('img/delete.png') }}" alt="close">
                            </div>
                            <div class="modal-body">
                                <textarea style="height: 400px; margin-top:10px;border-radius:0" class="text-input">{{  $question->content }}</textarea>
                            </div>
                        </div>
                        </td>
                        <td>
                            <div data-req-id="{{ $question->id }}" class="show-bar">
                                <img src="{{ asset('img/detail.png') }}" alt="add"
                                id="addNewUser">
                            </div>
                        </td>
                        <td>
                            <div data-matr="{{ $question->id }}" class="mat-bar" style="display:flex; justify-content:center;">
                                <img src="{{ asset('img/files.png') }}" alt="add"
                                id="addNewUser" style="width:40px;height:40px; cursor:pointer;">
                            </div>
                            <div class="modal-edit" data-material="{{ $question->id }}">
                                <div class="modal-header">
                                    <img id="close-modal" src="{{ asset('img/delete.png') }}" alt="close">
                                </div>
                                @if ($question->materials)
                                    <p class="dop-materials">Додаткові матеріали</p>
                                    <table class="main-table form-work">
                                        @foreach (json_decode($question->materials) as $material)
                                        <tr>
                                            <td>
                                            <a href="{{ URL::to($material->link) }}">{{ $material->title }}</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                @else
                                    <h2 style="padding: 20px 0; text-align:center;">Матеріали відсутні</h2>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                <!-- Form answer -->
                <div class="modal" id="modal-answer">
                    <div class="modal-header">
                        <img id="close-modal-delete" src="{{ asset('img/delete.png') }}" alt="close">
                    </div>
                    <div class="id"></div>
                    <form action="{{ route('moderator.usersQuestionAnswer') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" hidden class="feedback_id" name="feedback_id">
                        <label for="">
                            <p style="font-size: 20px;padding: 10px 0;">Відповідь</p>
                            <textarea class="text-input" name="content" style="resize:none;width: 100%;height: 230px;"></textarea>
                        </label>
                        <div class="group-end" style="display: flex;justify-content: space-between;margin-top: 10px;">
                            <label for="">
                                <p>Дод. матеріали</p>
                                <input type="file" name="attachment[]" multiple/>
                            </label>
                            <button type="submit" class="btn-submit-input">Відправити</button>
                        </div>
                    </form>
                </div>
                <!-- Form answer -->
            </table>
            @isset($questions)
            <div class="wrapped-elements">
                {{ $questions->appends(request()->query())->links() }}
            </div>
            @endisset
        @endif
    </div>
    <div class="overlay"></div>
@endsection

@section('script')
    <script defer>


        // form
        var changeForm = document.querySelector('#type-sort');
        var form = document.querySelector('#go-sort');
        // changeForm.addEventListener('change', function(){
        //     //form.submit();
        //     console.log('dddd');
        // });
        // // rorm
        var showQuestion = document.querySelectorAll('.show-question');
        var modalQuest = document.querySelectorAll('.modal-quest');
        var closeQ =document.querySelectorAll('.modal-header-req');

        closeQ.forEach(function(Head){
            Head.addEventListener('click', function(){
                overflay.classList.remove('show-block');
                var headId = this.getAttribute('data-req-id');
                modalQuest.forEach(function(Body){
                    if(Body.getAttribute('data-req-id') == headId ){
                        Body.classList.remove('show-block');
                    }
                });
            });
        });

        showQuestion.forEach(function(item){
            item.addEventListener('click', function(){
                var idData = this.getAttribute('data-req-id');
                modalQuest.forEach(function(second){
                    if(second.getAttribute('data-req-id') == idData){
                        second.classList.add('show-block');
                        overflay.classList.add('show-block');
                    }
                });
            });
        });


        var butns = document.querySelectorAll('.show-bar');
        var formGo = document.querySelector('#modal-answer');
        var overflay = document.querySelector('.overlay');
        var inputId = document.querySelector('.feedback_id');
        var closeModals = document.querySelectorAll('#close-modal');

        closeModals.forEach(function(itemC){
            itemC.addEventListener('click', function(){
                overflay.classList.remove('show-block');
                modalEdits.forEach(function(item){
                    if(item.classList.contains('show-block')){
                        item.classList.remove('show-block');
                    }
                });
            });
        });

        overflay.addEventListener('click', function(){
                formGo.classList.remove('show-block');
                overflay.classList.remove('show-block');
                modalEdits.forEach(function(item){
                    if(item.classList.contains('show-block')){
                        item.classList.remove('show-block');
                    }
                });
                modalQuest.forEach(function(second){
                    if(second.classList.contains('show-block')){
                        second.classList.remove('show-block');
                    }
                });
        });

        formGo.querySelector('#close-modal-delete').addEventListener('click', function(){
                formGo.classList.remove('show-block');
                overflay.classList.remove('show-block');
        });

        butns.forEach(function(item){
            var idData = item.getAttribute('data-req-id');
            item.addEventListener('click', function(){
                inputId.setAttribute('value', idData);
                formGo.classList.add('show-block');
                overflay.classList.add('show-block');
            });
        });

        var btnMarts = document.querySelectorAll('.mat-bar');
        var modalEdits =  document.querySelectorAll('.modal-edit');

        btnMarts.forEach(function(itemFirst){
            itemFirst.addEventListener('click', function(){
                var dataReq = this.getAttribute('data-matr');
                modalEdits.forEach(function(itemSecond){
                    if(itemSecond.getAttribute('data-material') == dataReq){
                        itemSecond.classList.add('show-block');
                        overflay.classList.add('show-block');
                    }
                });
            });
        });

    </script>
@endsection
