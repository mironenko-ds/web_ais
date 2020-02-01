@extends('moderator.layout.template')
@section('title', 'Зв\'язатися з адміністратором')
@section('content')
<div class="page__title">
    <a href="{{ route('moderator.index') }}">Головна</a>
    <img src="{{ asset('img/next.png') }}" alt="">
    <a href="{{ route('moderator.feedback') }}">Зв'язатися з адміністратором</a>
</div>
<div class="user-feedback block">
    @if (session('successFeedback'))
    <div class="send-mes">
        <h1>{{ session()->get('successFeedback') }}</h1>
    </div>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('moderator.feedbackSend') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-header">
            <label for="tema">
                <p>Тема</p>
                <input id="tema" name="tema" type="text" class="text-input" required>
            </label>
            <label for="">
                <p>Одержувач</p>
                <select name="type-user" id="type-user">
                    <option value="3">Адміністратор</option>
                </select>
            </label>
        </div>
        <textarea class="text-input" name="content" required></textarea>
        <div class="form-buttom-group">
            <input type="file" name="attachment[]" multiple/>
            <button type="submit" class="btn-submit-input">Відправити</button>
        </div>
    </form>
</div>
@endsection

