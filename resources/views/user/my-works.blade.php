@extends('user.layout.template')
@section('title', 'Мои работы')
@section('content')
<div class="page__title">
    <a href="{{ route('user.index') }}">Главная</a>
    <img src="{{ asset('img/next.png') }}" alt="next">
    <a href="{{ route('user.works') }}">Мои работы</a>
</div>
<div class="user-works block">
    @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    @if (session('errorSendMessage'))
        <div class="">
            {{ session()->get('errorSendMessage') }}
        </div>
    @endif
    @if (session('successSend'))
        <div class="">
            {{ session()->get('successSend') }}
        </div>
    @endif



    @if (isset($noWorks))
        <h1>{{ $noWorks }}</h1>
    @else
        <table class="main-table">
            <tr>
                <th>
                    Название работы
                </th>
                <th>
                    Дата создания работы
                </th>
                <th>
                    Доля по плану[%]
                </th>
                <th>
                    Доля по факту[%]
                </th>
                <th>
                    Вид работы <span title="Тип выполненной работы">*</span>
                </th>
                <th>
                    Подробнее
                </th>
                <th>
                    Редактировать <span title="Укажите что нужно изменить и модератор подправит.">*</span>
                </th>
            </tr>

            @foreach ($works as $work)
                <tr>
                    <td>
                        {{ $work->title }}
                    </td>
                    <td>
                        {{ $work->created_at->format('m/d/Y') }}
                    </td>
                    <td>
                        {{ $work->percentage_plan }}
                    </td>
                    <td>
                        {{ $work->percentage_fact }}
                    </td>
                    <td>
                        {{ $work->work->indicator }}
                    </td>
                    <td>
                        <div class="show-bar">
                            <img data-work-id="{{ $work->id }}" data-modal="show" src="{{ asset('img/detail.png') }}" alt="show">
                        </div>
                    </td>
                    <td>
                        <div class="edit-bar">
                            <img data-name-work="{{ $work->title }}" data-modal="edit" src="{{ asset('img/spec-edit.png') }}" alt="edit">
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
    @isset($works)
    <div class="wrapped-elements">
        {{ $works->onEachSide(2)->links() }}
    </div>
    @endisset
    <!-- Modal window show work -->


    @if (!isset($noWorks))
        @foreach ($works as $work)
        <div class="modal-edit" modal="edit-{{ $work->id }}" data-work-id="{{ $work->id }}">
            <div class="modal-header">
                <img id="close-modal-edit" data-work-id="{{ $work->id }}" src="{{ asset('img/delete.png') }}" alt="close">
            </div>
            <div class="modal-body">
                <form action="">
                    <label for="tema">
                        <p>Название работы</p>
                        <h2 style="font-size: 20px; font-weight: 500;padding-bottom: 10px;
                    ">{{ $work->title }}</h2>
                    </label>
                    <label for="tema">
                        <p>Описание работы</p>
                        <textarea class="fix-textarea">{{ $work->description }}</textarea>
                    </label>
                    <h3 class="work-title-h3">Характеристики работы</h3>
                    <table class="main-table form-work">
                        <tr>
                            <td>
                                <p>Норма на первый семестр по плану</td>
                            </td>
                            <td>
                                {{ $work->norm_semester_1_plan }}
                            </td>
                        </tr>
                        <tr>
                           <td>
                                <p>Норма на второй семестр по плану</p>
                           </td>
                           <td>
                            {{ $work->norm_semester_2_plan }}
                           </td>
                        </tr>
                        <tr>
                            <td>
                            <p>Количество по плану</p>
                            </td>
                            <td>
                                {{ $work->count_plan }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Доля по плану</p>
                            </td>
                            <td>
                                {{ $work->percentage_plan }}
                            </td>
                        </tr>
                        <tr>
                            <td><p>Дата записи плана</p></td>
                            <td>{{ $work->created_at->format('m/d/Y') }}</td>
                        </tr>
                        <tr>
                            <td><p>Норма на первый семестр по факту</p></td>
                            <td>{{ $work->norm_semester_1_fact }}</td>
                        </tr>
                        <tr>
                            <td><p>Норма на второй семестр по факту</p></td>
                            <td>{{ $work->norm_semester_2_fact }}</td>
                        </tr>
                        <tr>
                            <td><p>Количество фактическое:</p></td>
                            <td>{{ $work->count_fact }}</td>
                        </tr>
                        <tr>
                            <td><p>Доля факт</p></td>
                            <td>{{ $work->percentage_fact }}</td>
                        </tr>
                    </table>
                </form>
                @if ($work->materials)
                    <p class="dop-materials">Дополнительные материалы</p>
                    <table class="main-table form-work">
                        @foreach (json_decode($work->materials) as $item)
                        <tr>
                            <td>
                            <a href="{{ URL::to($item->link) }}">{{ $item->title }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
        @endforeach
    @endif

    <!-- Modal window show work -->

    <!-- Modal window edit -->
    <div class="modal" modal="edit">
        <div class="modal-header">
            <img id="close-modal" src="{{ asset('img/delete.png') }}" alt="close">
        </div>
        <div class="modal-body">
            <form action="{{ route('user.EditWork') }}" method="POST">
                @csrf
                <label for="tema">
                    <p>Тема</p>
                    <input type="text" id="tema" required readonly name="tema" value="" class="text-input">
                </label>
                <label for="">
                    <p>Укажите что нужно изменить</p>
                    <textarea name="content" class="text-input" required></textarea>
                </label>
                <div class="form-btn">
                    <input type="submit" value="Отправить" class="btn-submit-input">
                </div>
            </form>
        </div>
    </div>
    <!-- Modal window edit -->
</div>
<div class="overlay"></div>
@endsection

@section('script')
    <script defer>

        var butShowWork = document.querySelectorAll('.show-bar img');
        var showModals = document.querySelectorAll('.modal-edit');
        var closeEdit = document.querySelectorAll('#close-modal-edit');

        closeEdit.forEach(function(item){
            item.addEventListener('click', function(item){
                var idClose =  this.getAttribute('data-work-id');
                showModals.forEach(function(item){
                    if(idClose == item.getAttribute('data-work-id')){
                        item.classList.remove('show-block');
                        overlay.classList.remove('show-block');
                    }
                });
            });
        });

        butShowWork.forEach(function(item){

            item.addEventListener("click", function(event){
            var butId =  this.getAttribute('data-work-id');

            showModals.forEach(function(item){
                var modalId = item.getAttribute('data-work-id');
                if(modalId == butId){
                    item.classList.add('show-block');
                    overlay.classList.add('show-block');
                }
            });
        });
        });



        /////////////////////////////////
        var arrayLinks = document.querySelectorAll(".edit-bar img");
        var modal = document.querySelector(".modal");
        var overlay = document.querySelector(".overlay");
        var closeModal = modal.querySelector("#close-modal");
        var titleForm = modal.querySelector('input#tema');

        arrayLinks.forEach(function (item) {
            item.addEventListener("click", function (event) {
                event.preventDefault();
                var title = "Редактирования темы " + item.getAttribute('data-name-work');

                titleForm.value = title;

                modal.classList.add('show-block');
                overlay.classList.add('show-block');

            });
        });

        // close

        overlay.addEventListener("click", function (event) {
            modal.classList.remove('show-block');
            showModals.forEach(function(item){
                if(item.classList.contains('show-block')){
                    item.classList.remove('show-block');
                }
            });
            overlay.classList.remove('show-block');
        });

        closeModal.addEventListener("click", function (event) {
            modal.classList.remove('show-block');
            overlay.classList.remove('show-block');
        });


    </script>
@endsection
