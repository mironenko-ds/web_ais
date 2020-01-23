@extends('user.layout.template')
@section('title', 'Связаться с модератором')
@section('content')
<div class="page__title">
<a href="{{ route('user.index') }}">Главная</a>
    <img src="{{ asset('img/next.png') }}" alt="next">
<a href="{{ route('user.feedback') }}">Связь с модератором</a>
</div>
<div class="user-feedback block">
    @if (session('successFeedback'))
    <div class="send-mes">
        <h1>{{ session()->get('successFeedback') }}</h1>
    </div>
    @endif

    <form action="{{ route('user.sendMessageUser') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-header">
            <label for="tema">
                <p>Тема</p>
                <input id="tema" name="tema" type="text" class="text-input" required>
            </label>
            <label for="">
                <p>Получатель</p>
                <select name="type-user" id="type-user">
                    <option value="2">Модератор</option>
                    <option value="3">Администратор</option>
                </select>
            </label>
        </div>
        <textarea class="text-input" name="content" required></textarea>
        <div class="form-buttom-group">
            <input type="file" name="attachment[]" multiple/>
            <button type="submit" class="btn-submit-input">Отправить</button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    var link = "{{ asset('img/delete.png') }}";
    var addMaterial = document.querySelector(".add-materials");

    addMaterial.addEventListener("click", function () {
        NewInput(".file-inputs", link);
    })
</script>
@endsection
