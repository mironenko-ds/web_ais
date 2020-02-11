@extends('administrator.layout.template')
@section('title', 'Управління факультетами')
@section('content')
    <div class="page__title">
        <a href="{{ route('admin.index') }}">Головна</a>
        <img src="{{ asset('img/next.png') }}" alt="next">
        <a href="{{ route('admin.management') }}">Управління факультетами</a>
    </div>
    <div class="user-works block-no-padding">
        <div class="header">
            <div class="header-item">
                    <p>Кількість кафедр: </p>
                </div>
                <div class="header-item">
                    <form id="go-sort" action="" method="get">
                        <label for="sort">
                            <p>Сортування</p>
                            @if (!empty($get_req))
                                <select name="value" id="sort">
                                    <option value="1"
                                    {{$get_req['val'] == 1 ? 'selected' : null}}
                                    >назва факультету</option>
                                    <option value="2"
                                    {{$get_req['val'] == 2 ? 'selected' : null}}
                                    >завідувач факультету</option>
                                </select>
                            @else
                            <select name="value" id="sort">
                                <option value="1">назва факультету</option>
                                <option value="2">завідувач факультету</option>
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
                <div class="header-item">
                        <img src="{{ asset('img/add.png') }}" alt="add" id="add-dep">
                </div>
            </div>
            <table class="main-table" style="margin-top:20px; width:100%">
                <tr>
                    <th>
                        Назва факультету
                    </th>
                    <th>
                        Завідувач факультету
                    </th>
                    <th>
                        Редагувати
                    </th>
                    <th>
                        Видалити
                    </th>
                    <th>
                        Кафедри
                    </th>
                </tr>
                @foreach ($facultes as $faculty)
                    <tr>
                        <td>
                            {{ $faculty->faculty_name }}
                        </td>
                        <td>
                            {{ $faculty->head_faculty }}
                        </td>
                        <td style="padding: 0; text-align:left;">
                           {{-- <textarea readonly style="width:100%; height:200px; resize:none; border:none;">{{ $question->content }}</textarea> --}}
                           <div data-req-id="{{ $faculty->id }}" class="show-question">
                            <img src="{{ asset('img/detail.png') }}" alt="add">
                        </div>
                        <div class="modal modal-quest" data-req-id="{{ $faculty->id }}">
                            <div class="modal-header modal-header-req" data-req-id="{{ $faculty->id }}">
                                <img  src="{{ asset('img/delete.png') }}" alt="close">
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.facultyEdit') }}" method="POST">
                                    @csrf
                                    <input required type="text" name="id" hidden value="{{ $faculty->id }}">
                                    <label for="name">
                                        <p>Назви факультету</p>
                                        <input required type="text" name="faculty_name" class="text-input" value="{{ $faculty->faculty_name }}">
                                    </label>
                                    <label for="head">
                                        <p>Завідувач факультету</p>
                                        <input type="text" name="head_faculty" class="text-input" value="{{ $faculty->head_faculty }}">
                                    </label>
                                    <div class="f-btn">
                                        <input type="submit" class="btn-submit-input" value="Оновити">
                                    </div>
                                </form>
                            </div>
                        </div>
                        </td>
                        <td>
                            <div data-req-id="{{ $faculty->id }}" class="show-bar">
                                <img src="{{ asset('img/delete-user.png') }}" alt="add"
                                id="addNewUser">
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.faculty', $faculty->id) }}">
                                <img class="dep-link" src="{{ asset('img/link.png') }}" alt="dep-link">
                            </a>
                        </td>
                    </tr>
                @endforeach
                <!-- Form answer -->
                <div class="modal" id="modal-answer">
                    <div class="modal-header">
                        <img id="close-modal-delete" src="{{ asset('img/delete.png') }}" alt="close">
                    </div>
                    <div class="id"></div>
                    <form action="{{ route('admin.deleteFaculty') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" hidden class="feedback_id" name="departament_id">
                        <p style="padding: 5px;font-size: 18px;font-weight: 500; font-family:Montserrat;"
                        >Ви дійсно хочете видалити факультет?
                        При видаленні факультету ви видалите всі кафедри і дані з ними пов'язані.</p>
                        <p style="padding:5px">Введіть код для видалення</p>
                        <input class="text-input" style="width:100%; padding:5px;" type="text" name="code_delete" id="">
                        <div class="f-btn">
                            <input type="submit" class="btn-submit-input" value="Видалити">
                        </div>
                    </form>
                </div>
                <!-- Form answer -->
            </table>
            @isset($facultes)
            <div class="wrapped-elements">
                {{ $facultes->appends(request()->query())->links() }}
            </div>
            @endisset
    </div>
    <div class="overlay"></div>
    <div class="modal new-dep-model" style="width: 500px;">
        <div class="modal-header close-dep">
            <img  src="{{ asset('img/delete.png') }}" alt="close">
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.facultyNew') }}" method="POST">
                @csrf
                <label for="name">
                    <p>Назви факультету</p>
                    <input style="width:100%" required type="text" name="faculty_name" class="text-input">
                </label>
                <label for="head">
                    <p>Завідувач факультету</p>
                    <input style="width:100%" type="text" name="head_faculty" class="text-input">
                </label>

                <div class="f-btn">
                    <input type="submit" class="btn-submit-input" value="Добавити">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script defer>


        var newDep = document.querySelector('#add-dep');
        var ModelDep = document.querySelector('.new-dep-model');
        var closeModelDep = document.querySelector('.close-dep');

        newDep.addEventListener('click', function(){
            ModelDep.classList.add('show-block');
            overflay.classList.add('show-block');
        });

        closeModelDep.addEventListener('click', function(){
            ModelDep.classList.remove('show-block');
            overflay.classList.remove('show-block');
        });



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
                if(ModelDep.classList.contains('show-block')){
                    ModelDep.classList.remove('show-block');
                }
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
