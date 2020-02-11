@extends('user.layout.template')
@section('title', 'Нова робота')
@section('content')
<div class="page__title">
    <a href="{{ route('user.index') }}">Головна</a>
    <img src="{{ asset('/img/next.png') }}" alt="next">
    <a href="{{ route('user.addWork') }}">Нова робота</a>
</div>
<div class="user-add-work block">
    <div class="info-author">
        @if ($errors->any())
        <div class="wrapped-new-user-error">
            <ul class="show-errors-server">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (session('errorMake'))
            <div class="error-make">
                {{ session()->get('errorMake') }}
            </div>
        @endif
        @if (session('successWork'))
            <div class="good-new-work">
                {{ session()->get('successWork') }}
            </div>
        @endif
        <div class="header">
            <h2>
                Інформація про автора
            </h2>
            <img src="{{ asset('img/no-edit.png') }}" alt="no-edit">
        </div>
        <label for="user">
            <p>Викладач</p>
        <input type="text" id="user" class="text-input" readonly value="{{$employee}}">
        </label>
        <div class="wrap-el">
            <label for="faculty">
                <p>Факультет</p>
                <input type="text" id="faculty" class="text-input" readonly value="{{$facultyName}}">
            </label>
            <label for="departament">
                <p>Кафедра</p>
                <input type="text" id="departament" class="text-input" readonly value="{{$departamentName}}">
            </label>
            <label for="year">
                <p>Навчальний рік</p>
                <input type="text" id="year" class="text-input" readonly value="{{$year}}">
            </label>
        </div>
        <label for="date-plane">
            <p>Дата запису плану</p>
            <input type="text" id="date-plane" class="text-input" readonly value="{{$date}}">
        </label>
    </div>
    <form action="{{ route('user.CreateWork') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="config-work">
            <div class="title">
                <h2>Характеристика проекту</h2>
            </div>
            <div class="input-group">
                <label for="norma-1-plane">
                    <p>Норма на 1й семестр за планом</p>
                    <input type="number" min="0" max="2147483647" name="norma-1-plane" required id="norma-1-plane" class="text-input">
                </label>
                <label for="norma-2-plane">
                    <p>Норма на 2й семестр за планом</p>
                    <input type="number" min="0" max="2147483647" name="norma-2-plane" required id="norma-2-plane" class="text-input">
                </label>
                <label for="count-plane">
                    <p>Кількість за планом</p>
                    <input type="number" min="0" max="2147483647" name="count-plane" required id="count-plane" class="text-input">
                </label>
                <label for="share-plane">
                    <p>Частка за планом</p>
                    <input type="number" min="0" max="2147483647" name="share-plane" required id="share-plane" class="text-input">
                </label>
                <label for="norma-1-fact">
                    <p>Норма на 1й семестр за фактом</p>
                    <input value="0"  type="number" min="0" max="2147483647" name="norma-1-fact" required id="norma-1-fact" class="text-input">
                </label>
                <label for="norma-2-fact">
                    <p>Норма на 2й семестр за фактом</p>
                    <input value="0" type="number" min="0" max="2147483647" name="norma-2-fact" required id="norma-2-fact" class="text-input">
                </label>
                 <label for="count-fact">
                    <p>Кількість за фактом</p>
                    <input value="0" type="number" min="0" max="2147483647" name="count-fact" required id="count-fact" class="text-input">
                </label>
                <label for="share-fact">
                    <p>Частка за фактом</p>
                    <input  value="0" type="number" min="0" max="2147483647" name="share-fact" required id="share-fact" class="text-input">
                </label>
            </div>
                <div class="type-work">
                    <label for="t-work">
                        <p>Тип роботи</p>
                        <select id="t-work" class="text-input">
                            @foreach ($type_work as $twork)
                                <option value="{{ $twork->id }}">{{ $twork->name_type_work }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label for="k-work">
                        <p>Назва виду роботи</p>
                        <select id="k-work" class="text-input">
                            @foreach ($work_kinds as $wkind)
                                <option value="{{ $wkind->id }}">{{ $wkind->kind_name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label for="ratio">
                        <p>Работа</p>
                        <select name="work" id="ratio" class="text-input">
                            @foreach ($works as $work)
                                <option value="{{ $work->id }}">{{ $work->indicator }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
        </div>
        <div class="content-work">
            <label for="work-title">
                <p>Назва роботи</p>
                <input type="text" name="work-title" required id="work-title" class="text-input">
            </label>
            <p>Опис роботи</p>
            <textarea class="text-input" name="desc-work" required></textarea>
        </div>
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

@section('script')
    <script defer>
        var works = {!! json_encode($jsonWork) !!};
        var workKinds = {!! json_encode($jsonWorkKinds) !!};
        var typeWork = {!! json_encode($jsonTypeWork) !!};
        console.dir(works);
       var selectTypeWork = document.getElementById('t-work');
       var selectKindWork = document.getElementById('k-work');
       var ratio = document.getElementById('ratio');
       var points = document.getElementById('count-point');

       selectTypeWork.addEventListener("change", function(){
            setKindWork();
       })

       setKindWork();

       function setKindWork(){
            // clear
            while (selectKindWork.firstChild) {
                selectKindWork.removeChild(selectKindWork.firstChild);
            }
            // get items type_work->kinds_works
            for(var iter = 0; iter < workKinds.original.length; iter++){
                var option = document.createElement('option');
                if(workKinds.original[iter].type_work_id == +selectTypeWork.value){
                    option.value = workKinds.original[iter].id;
                    option.innerHTML = workKinds.original[iter].kind_name;
                    selectKindWork.append(option);
                }
            }
            setWork();
       }

       selectKindWork.addEventListener('change', function(){
            setWork();
       });

       function setWork(){
            // clear
            while (ratio.firstChild) {
                ratio.removeChild(ratio.firstChild);
            }
            // get items kinds_works->works
            for(var iterator = 0; iterator < works.original.length; iterator++){
                var opt = document.createElement('option');
                if(works.original[iterator].works_kinds_id == +selectKindWork.value){
                    opt.value = works.original[iterator].id;
                    opt.innerHTML = works.original[iterator].indicator;
                    ratio.append(opt);
                }
            }

       }

    </script>
@endsection
