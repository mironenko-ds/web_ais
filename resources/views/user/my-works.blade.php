@extends('user.layout.template')
@section('title', 'Мои работы')
@section('content')
<div class="page__title">
    <a href="{{ route('user.index') }}">Главная</a>
    <img src="{{ asset('img/next.png') }}" alt="next">
    <a href="{{ route('user.works') }}">Мои работы</a>
</div>
<div class="user-works block">
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
        <tr>
            <td>
                Создание веб-аис
            </td>
            <td>
                2020.01.15
            </td>
            <td>
                100
            </td>
            <td>
                100
            </td>
            <td>
                Научная работа
            </td>
            <td>
                <div class="show-bar">
                    <img data-work-id="32" data-modal="show" src="{{ asset('img/detail.png') }}" alt="show">
                </div>
            </td>
            <td>
                <div class="edit-bar">
                    <img data-modal="edit" src="{{ asset('img/spec-edit.png') }}" alt="edit">
                </div>
            </td>
        </tr>
    </table>
    <!-- Modal window show work -->

    <!-- Modal window show work -->

    <!-- Modal window edit -->
    <div class="modal" modal="edit">
        <div class="modal-header">
            <h2>
                Title
            </h2>
            <img id="close-modal" src="{{ asset('img/delete.png') }}" alt="close">
        </div>
        <div class="modal-body">

        </div>
    </div>
    <!-- Modal window edit -->
</div>
<div class="overlay"></div>
@endsection

@section('script')
    <script defer>

        var butShowWork = document.querySelector('.show-bar img');

        butShowWork.addEventListener("click", function(event){
            console.log(+this.getAttribute('data-work-id'));
        });



        /////////////////////////////////
        var arrayLinks = document.querySelectorAll(".edit-bar img");
        var modal = document.querySelector(".modal");
        var overlay = document.querySelector(".overlay");
        var closeModal = modal.querySelector("#close-modal");

        arrayLinks.forEach(function (item) {
            item.addEventListener("click", function (event) {
                event.preventDefault();

                modal.classList.add('show-block');
                overlay.classList.add('show-block');

            });
        });

        // close

        overlay.addEventListener("click", function (event) {
            modal.classList.remove('show-block');
            overlay.classList.remove('show-block');
        });

        closeModal.addEventListener("click", function (event) {
            modal.classList.remove('show-block');
            overlay.classList.remove('show-block');
        });


    </script>
@endsection
