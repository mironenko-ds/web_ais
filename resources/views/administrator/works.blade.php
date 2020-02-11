@extends('administrator.layout.template')
@section('title', $group_work_name)
@section('content')
    <div class="page__title">
        <a href="{{ route('admin.index') }}">Головна</a>
        <img src="{{ asset('img/next.png') }}" alt="next">
        <a href="{{ route('admin.typeWorkShow') }}">Роботи</a>
        <img src="{{ asset('img/next.png') }}" alt="next">
        <a href="{{ route('admin.workGroupShow', $group_work_id) }}">{{$group_work_name}}</a>
    </div>
    <div class="user-works block-no-padding">
        <div class="header">
            <div class="header-item">
                    <p>Кількість робіт: {{$Works->total()}}</p>
                </div>
                @if ($Works->total() != 0)
                <div class="header-item">
                    <form id="go-sort" action="" method="get">
                        <label for="sort">
                            <p>Сортування</p>
                            @if (!empty($get_req))
                                <select name="value" id="sort">
                                    <option value="1"
                                    {{$get_req['val'] == 1 ? 'selected' : null}}
                                    >назва роботи</option>
                                    <option value="2"
                                    {{$get_req['val'] == 2 ? 'selected' : null}}
                                    >опис роботи</option>
                                </select>
                            @else
                            <select name="value" id="sort">
                                <option value="1">назва роботи</option>
                                <option value="2">опис роботи</option>

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
                @endif
                <div class="header-item">
                        <img src="{{ asset('img/add.png') }}" alt="add" id="add-dep">
                </div>
            </div>
            @if (session('noDelete'))
                <div class="error-make" style="text-align: center;padding: 10px;padding-bottom: 0;
                    ">
                    {{ session()->get('noDelete') }}
                </div>
            @endif
            @if ($Works->total() == 0)
                <h1 style="text-align: center;padding: 20px;"
                >Роботи відсутні</h1>
            @else
            <table class="main-table" style="margin-top:20px; width:100%">
                <tr>
                    <th>
                        Назва роботи
                    </th>
                    <th>
                        Описи роботи
                    </th>
                    <th>
                        Норма балів
                    </th>
                    <th>
                        Норма годин
                    </th>
                    <th>
                        Примітка
                    </th>
                    <th>
                        Редагувати
                    </th>
                    <th>
                        Видалити
                    </th>
                </tr>
                @foreach ($Works as $work)
                    <tr>
                         <td>
                            {{ $work->indicator }}
                        </td>

                        <td>
                            {{ $work->norm_desc }}
                        </td>

                         <td>
                            @if ($work['norm-point'] != null)
                            {{ $work['norm-point'] }}
                            @else
                            <p style="text-align:center">----</p>
                            @endif
                        </td>

                        <td>
                            @if ($work['norm-hour'] != null)
                            {{ $work['norm-hour'] }}
                            @else
                                <p style="text-align:center">----</p>
                            @endif
                        </td>
                        <td>
                           @if ($work->description != null)
                           {{ $work->description }}
                           @else
                                <p style="text-align:center">----</p>
                           @endif
                        </td>
                        <td style="padding: 0; text-align:left;">
                           {{-- <textarea readonly style="width:100%; height:200px; resize:none; border:none;">{{ $question->content }}</textarea> --}}
                           <div data-req-id="{{ $work->id }}" class="show-question">
                            <img src="{{ asset('img/detail.png') }}" alt="add">
                        </div>
                        <div class="modal modal-quest" data-req-id="{{ $work->id }}"
                            style="width: 553px; max-height: 95vh; overflow: auto;"
                            >
                            <div class="modal-header modal-header-req" data-req-id="{{ $work->id }}">
                                <img  src="{{ asset('img/delete.png') }}" alt="close">
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.worksEdit') }}" method="POST">
                                    @csrf
                                    <input required type="text" name="id" hidden value="{{ $work->id }}">
                                    <label for="indicator">
                                        <p>Назва роботи</p>
                                        <input required type="text" name="indicator" class="text-input" value="{{ $work->indicator }}">
                                    </label>
                                    <label for="norm_desc">
                                        <p>Описи роботи</p>
                                        <textarea required name="norm_desc" class="text-input">{{$work->norm_desc}}</textarea>
                                    </label>
                                    <label for="norm-point">
                                        <p>Норма балів</p>
                                        <input type="text" name="norm-point" class="text-input" value="{{ $work['norm-point'] }}">
                                    </label>
                                    <label for="name">
                                        <p>Норма годин</p>
                                        <input type="text" name="norm-hour" class="text-input" value="{{ $work['norm-hour'] }}">
                                    </label>
                                    <label for="description">
                                        <p>Примітка</p>
                                        <textarea name="description" class="text-input">{{$work->description}}</textarea>
                                    </label>
                                    <div class="f-btn">
                                        <input type="submit" class="btn-submit-input" value="Оновити">
                                    </div>
                                </form>
                            </div>
                        </div>
                        </td>
                        <td>
                            <div data-req-id="{{ $work->id }}" class="show-bar">
                                <img src="{{ asset('img/delete-user.png') }}" alt="add"
                                id="addNewUser">
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
                    <form action="{{ route('admin.worksDelete') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" hidden class="feedback_id" name="work_id">
                        <p style="padding: 5px;font-size: 18px;font-weight: 500; font-family:Montserrat;text-align:center;"
                        >Ви дійсно хочете видалити роботу?</p>
                        <div class="f-btn" style="justify-content: space-evenly">
                            <input type="submit" class="btn-submit-input" value="Так">
                            <button class="btn-submit-input no-delete">Ні</button>
                        </div>
                    </form>
                </div>
                <!-- Form answer -->
            </table>
            @endif
            @if ($Works->total() != 0)
            <div class="wrapped-elements">
                {{ $Works->appends(request()->query())->links() }}
            </div>
            @endif
    </div>
    <div class="overlay"></div>




    <div class="modal new-dep-model" style="width: 553px; max-height: 95vh; overflow: auto;">
        <div class="modal-header close-dep">
            <img  src="{{ asset('img/delete.png') }}" alt="close">
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.worksNew') }}" method="POST">
                @csrf
                <input required type="text" name="works_kinds_id" hidden value="{{ $group_work_id }}">
                <label for="indicator"
                style="display: flex;flex-direction: column;margin-bottom: 10px;">
                    <p>Назва роботи</p>
                    <input required type="text" name="indicator" class="text-input">
                </label>
                <label for="norm_desc"
                style="display: flex;flex-direction: column;margin-bottom: 10px;">
                    <p>Описи роботи</p>
                    <textarea style="resize: none;width: 100%;height: 180px;" required name="norm_desc" class="text-input"></textarea>
                </label>
                <label for="norm-point"
                style="display: flex;flex-direction: column;margin-bottom: 10px;">
                    <p>Норма балів</p>
                    <input type="text" name="norm-point" class="text-input" value="">
                </label>
                <label for="name"
                style="display: flex;flex-direction: column;margin-bottom: 10px;">
                    <p>Норма годин</p>
                    <input type="text" name="norm-hour" class="text-input">
                </label>
                <label for="description"
                style="display: flex;flex-direction: column;margin-bottom: 10px;">
                    <p>Примітка</p>
                    <textarea style="resize: none;width: 100%;height: 180px;" name="description" class="text-input"></textarea>
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
        var btnNoDelete = document.querySelectorAll('.no-delete');

        btnNoDelete.forEach(function(item){
            //item.preventDefault();
            item.addEventListener('click', function(event){
                event.preventDefault();
                formGo.classList.remove('show-block');
                overflay.classList.remove('show-block');
            });
        });


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
