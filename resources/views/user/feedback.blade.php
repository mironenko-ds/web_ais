@extends('user.layout.template')
@section('title', 'Зв\'язатися з модератором')
@section('content')
<div class="page__title">
<a href="{{ route('user.index') }}">Головна</a>
    <img src="{{ asset('img/next.png') }}" alt="next">
<a href="{{ route('user.feedback') }}">Зв'язатися з модератором</a>
</div>
<div class="user-feedback block">
    @if ($errors->any())
        <div class="wrapped-new-user-error">
            <ul class="show-errors-server">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
                <p>Одержувач</p>
                <select name="type-user" id="type-user">
                    <option value="2">Модератор</option>
                    <option value="3">Адміністратор</option>
                </select>
            </label>
        </div>
        <textarea class="text-input" name="content" required></textarea>
        <div class="form-buttom-group">
            <div class="add-files">
                <p>Додаткові матеріали</p>
                <input type="file" name="attachment[]" multiple/>
            </div>
            <button type="submit" class="btn-submit-input">Відправити</button>
        </div>
    </form>
</div>
@endsection
