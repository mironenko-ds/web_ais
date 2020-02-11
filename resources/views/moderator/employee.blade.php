@extends('moderator.layout.template')
@section('title', 'Співробітники')
@section('content')
    <div class="page__title">
        <a href="{{ route('moderator.index') }}">Головна</a>
        <img src="{{ asset('img/next.png') }}" alt="next">
        <a href="{{ route('moderator.employees') }}">Співробітники</a>
    </div>
    <div class="user_offer block-no-padding" style="margin-top:30px;max-width: 1200px;">
        <!-- Show users -->
            @if (isset($UsersEmpty))
                <h1 style="text-align: center;padding: 15px 0;font-weight: 400;">
                    {{ $UsersEmpty }}
                </h1>
            @else
                <div class="header">
                    <div class="header-item">
                        <p>Співробітників на кафедрі: {{$users->total()}}</p>
                    </div>
                    <div class="header-item">
                        <form action="" method="get">
                            <label for="sort">
                                <p>Сортування</p>
                                @if (!empty($get_req))
                                    <select name="value" id="sort">
                                        <option value="1"
                                        {{$get_req['val'] == 1 ? 'selected' : null}}
                                        >дата реєстрації</option>
                                        <option value="2"
                                        {{$get_req['val'] == 2 ? 'selected' : null}}
                                        >посада</option>
                                        <option value="3"
                                        {{$get_req['val'] == 3 ? 'selected' : null}}
                                        >наукова ступінь</option>
                                        <option value="4"
                                        {{$get_req['val'] == 4 ? 'selected' : null}}
                                        >ім'я</option>
                                        <option value="5"
                                        {{$get_req['val'] == 5 ? 'selected' : null}}
                                        >прізвище</option>
                                    </select>
                                @else
                                <select name="value" id="sort">
                                    <option value="1">дата реєстрації</option>
                                    <option value="2">посада</option>
                                    <option value="3">наукова ступінь</option>
                                    <option value="4">ім'я</option>
                                    <option value="5">прізвище</option>
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
                <!--Erors -->
                    @if (session('successDelete'))
                        <div class="delete-user">
                            {{ session()->get('successDelete') }}
                        </div>
                    @endif
                    @if (session('successUpdate'))
                        <div class="delete-user" style="color: green;">
                            {{ session()->get('successUpdate') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                <!--Erors -->
                <!-- Table users -->
                <div class="wrap-table">
                    <table class="main-table">
                        <tr>
                            <th>
                                Прізвище
                            </th>
                            <th>
                                Посада
                            </th>
                            <th>
                                Наукова ступінь
                            </th>
                            <th>
                                Дата реєстрації
                            </th>
                            <th>
                                Редагувати
                            </th>
                            <th>
                                Видалити
                            </th>
                        </tr>
                    @foreach ($users as $user)
                            @if (Auth::user()->id == $user->id)
                                <tr style="background-color:rgba(0,0,0, .3);">
                            @else
                                <tr>
                            @endif
                            <td>
                                {{ $user->surname . ' ' . substr($user->name, 0, 2) . '.' . ' ' . substr($user->patronymic, 0, 2) . '.'}}
                            </td>
                            <td>
                                {{ $user->post->post_name }}
                            </td>
                            <td>
                                {{ $user->degree->degree_name }}
                            </td>
                            <td>
                                {{-- {{ $user->user->created_at->format('m/d/Y') }} --}}
                                {{-- ниже какое-то странный баг, я хер его значет что с ним не так
                                    так что не трогайте, а то вызывайте сатану --}}
                                {{ $user->created_at->format('m/d/Y') }}
                            </td>
                            <td>
                                <div class="edit-bar" data-user-id="{{ $user->id }}" style="cursor: pointer;display:flex;justify-content: center;">
                                    <img data-user-id="{{ $user->id }}" src="{{ asset('img/spec-edit.png') }}" alt="edit">
                                </div>
                            </td>
                            <td>
                                <div class="delete-bar" data-user-name="{{
                                    $user->surname . ' ' . substr($user->name, 0, 2) . '.' . ' ' . substr($user->patronymic, 0, 2) . '.'
                                 }}" data-user-id="{{ $user->id }}" style="cursor: pointer;display:flex;justify-content: center;">
                                    <img data-user-id="{{ $user->id }}" src="{{ asset('img/delete-user.png') }}" alt="delete">
                                </div>
                            </td>
                        </tr>
                        <!-- Modal form -->
                            <div class="modal-edit" data-user-id="{{ $user->id }}">
                                <div class="modal-header">
                                    <img id="close-modal" data-user-id="{{ $user->id }}" src="{{ asset('img/delete.png') }}" alt="close">
                                </div>
                                <div class="modal-body">
                                    <form class="form-work" action="{{ route('moderator.employeesEdit') }}" method="POST">
                                        @csrf
                                        <input type="text" name="user_id" hidden value="{{ $user->id }}">
                                        <label for="name" class="group-user">
                                            <p>Ім'я</p>
                                            <input type="text" name="name" required value="{{ $user->name }}" class="text-input">
                                        </label>
                                        <label for="surname" class="group-user">
                                            <p>Прізвище</p>
                                            <input type="text" name="surname" required value="{{ $user->surname }}" class="text-input">
                                        </label>
                                        <label for="patronymic" class="group-user">
                                            <p>По батькові</p>
                                            <input type="text" name="patronymic" required value="{{ $user->patronymic }}" class="text-input">
                                        </label>
                                        <div class="wrapped-edit" style="margin-top:10px;">
                                            <div class="group-label">
                                                <label for="faculty_id">Факультет</label>
                                            <select id="faculty_id" name="faculty">
                                            @foreach ($university['facultes'] as $faculty)
                                                <option value="{{ $faculty->id }}"
                                                {{ $faculty->faculty_name == $user->departament->faculty->faculty_name ? 'selected' : null }}
                                                >{{ $faculty->faculty_name }}</option>
                                            @endforeach
                                            </select>
                                            </div>

                                            <div class="group-label">
                                                <label for="departament_id">Кафедра</label>
                                            <select id="departament_id" name="departament">

                                            </select>
                                            </div>

                                            <div class="group-label">
                                                <label for="degree_id">Наукова&nbsp;ступінь</label>
                                            <select name="degree">
                                                @foreach ($university['degrees'] as $degree)
                                                    <option value="{{ $degree->id }}"
                                                    {{ $degree->degree_name == $user->degree->degree_name ? 'selected' : null }}
                                                    >{{ $degree->degree_name }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            <div class="group-label">
                                                <label for="post_id">Посада</label>
                                                <select name="post">
                                                    @foreach ($university['posts'] as $post)
                                                        <option value="{{ $post->id }}"
                                                        {{ $post->post_name == $user->post->post_name ? 'selected' : null }}
                                                        >{{ $post->post_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="submit" style="display:flex;justify-content: center">
                                            <input type="submit" class="btn-submit-input" value="Відправити">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <!-- Modal from -->
                    @endforeach
                    </table>
                </div>
                @isset($users)
                    <div class="wrapped-elements">
                        {{ $users->appends(request()->query())->onEachSide(2)->links() }}
                    </div>
                @endisset
                <!-- Table users -->
            @endif
        <!-- Show users -->
        <div class="modal-delete">
            <div class="modal-header">
                <img id="close-modal-delete" src="{{ asset('img/delete.png') }}" alt="close">
            </div>
            <div class="modal-body">
                <form id="form-del-user" action="{{ route('moderator.employeesDelete') }}" method="POST">
                    @csrf
                    <input type="answer_id" id="user-id" name="user_id" hidden value="">
                    <h2 class="requestText">Вы действительно хотите удалить сообщение?</h2>
                    <div class="btn-form-group">
                        <input type="submit" value="Да" style="background-color:red;" class="btn-submit-input">
                        <input id="no-delete-item" type="button" value="Нет" class="btn-submit-input">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
@endsection

@if (!isset($UsersEmpty))
@section('script')
    <script defer>

(
        function(){
            var departaments = {!! json_encode($university['allDep']) !!};
            var departament = document.querySelectorAll('#departament_id');
            var faculty = document.querySelectorAll('#faculty_id');

            for(var basic = 0; basic < faculty.length; basic++){
                var numFaculty = Number(faculty[basic].value);
                insertDepartaments(departaments, departament[basic], numFaculty);
            }

            faculty.forEach(function(item, index){
                var bn = index;
                    item.addEventListener('change', function(){
                        insertDepartaments(departaments, departament[bn], Number(item.value));
                });
            });

            function insertDepartaments(dep, departament1, value){
                var arrayItems = [];
                var readyElements = [];

                for(var iter = 0; iter < dep.original.length; iter++){

                    if(dep.original[iter].faculty_id === value){
                        arrayItems.push(dep.original[iter]);
                    }
                }

                for(var elIter = 0; elIter < arrayItems.length; elIter++){
                    var option = document.createElement('option');
                    option.value = arrayItems[elIter].id;
                    option.innerHTML = arrayItems[elIter].departament_name;
                    readyElements.push(option);
                }


                while (departament1.firstChild) {
                    departament1.removeChild(departament1.firstChild);
                    }

                    readyElements.forEach(function(item){
                        departament1.append(item);
                    });
            }
        }

    )()


        var allUsers = document.querySelectorAll('.edit-bar');
        var allForms = document.querySelectorAll('.modal-edit');
        var overlay = document.querySelector('.overlay');
        var closeEdits = document.querySelectorAll('#close-modal');
        var FormDeleteAll = document.querySelectorAll('.delete-bar');
        var FormDelete = document.querySelector('.modal-delete');
        var requestText = document.querySelector('.requestText');
        var UserId = document.querySelector('#user-id');
        var CloseModal = document.querySelector('#close-modal-delete');
        var NoDelete = document.querySelector('#no-delete-item');

        NoDelete.addEventListener('click', function(){
            FormDelete.classList.remove('show-block');
            overlay.classList.remove('show-block');
        });


        CloseModal.addEventListener('click', function(){
            FormDelete.classList.remove('show-block');
            overlay.classList.remove('show-block');
        });

        FormDeleteAll.forEach(function(item){

            item.addEventListener('click', function(){
                var nameUser = this.getAttribute('data-user-name');
                var nameId = this.getAttribute('data-user-id');
                FormDelete.classList.add('show-block');
                overlay.classList.add('show-block');
                var textRequest = 'Ви дійсно хочете видалити ' + nameUser + '?';
                requestText.textContent = textRequest;
                UserId.setAttribute('value', nameId);
            })
        });


        closeEdits.forEach(function(itemFirst){

            itemFirst.addEventListener('click', function(){

                dataU = this.getAttribute('data-user-id');

                allForms.forEach(function(itemSecond){
                    if(dataU == itemSecond.getAttribute('data-user-id')){
                        console.log(itemSecond);
                        itemSecond.classList.remove('show-block');
                        overlay.classList.remove('show-block');
                    }
                });

            });
        })

        allUsers.forEach(function(item){

            item.addEventListener('click', function(){

                var dataUser = this.getAttribute('data-user-id');
                allForms.forEach(function(item){
                    var dataForm = item.getAttribute('data-user-id');
                    if(dataUser == dataForm){
                        item.classList.add('show-block');
                        overlay.classList.add('show-block');
                    }
                });
            });
        });


        overlay.addEventListener('click', function(){
            overlay.classList.remove('show-block');
            if(FormDelete.classList.contains('show-block')){
                FormDelete.classList.remove('show-block');
            }
            allForms.forEach(function(item){
                if(item.classList.contains('show-block')){
                    item.classList.remove('show-block');
                }
            });
        });
    </script>
@endsection
@endif
