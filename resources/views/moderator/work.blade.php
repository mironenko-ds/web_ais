@extends('moderator.layout.template')
@section('title', $work->title)
@section('content')
<div class="page__title">
    <a href="{{ route('moderator.index') }}">Головна</a>

</div>
<div class="user-add-work block">
    <div class="info-author">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        @if (session('errorUpdate'))
            <div class="">
                {{ session()->get('errorUpdate') }}
            </div>
        @endif
        @if (session('successWork'))
            <div class="">
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
        <input type="text" id="user" class="text-input" readonly value="{{$work->employee->name}}">
        </label>
        <div class="wrap-el">
            <label for="faculty">
                <p>Факультет</p>
                <input type="text" id="faculty" class="text-input" readonly value="{{$work->departament->faculty->faculty_name}}">
            </label>
            <label for="departament">
                <p>Кафедра</p>
                <input type="text" id="departament" class="text-input" readonly value="{{$work->departament->departament_name}}">
            </label>
            <label for="year">
                <p>Навчальний рік</p>
                <input type="text" id="year" class="text-input" readonly value="{{$work->academic_year}}">
            </label>
        </div>
        <label for="date-plane">
            <p>Дата запису плану</p>
            <input type="text" id="date-plane" class="text-input" readonly value="{{$work->created_at->format('m/d/Y')}}">
        </label>
    </div>
    <form action="{{ route('moderator.editWork') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="work-id" hidden value="{{ $work->id }}">
        <div class="config-work">
            <div class="title">
                <h2>Характеристики проекту</h2>
            </div>
            <div class="input-group">
                <label for="norma-1-plane">
                    <p>Норма на 1й семестр за планом</p>
                    <input value="{{ $work->norm_semester_1_plan }}" pattern="\d+" type="text" name="norma-1-plane" required id="norma-1-plane" class="text-input">
                </label>
                <label for="norma-2-plane">
                    <p>Норма на 2й семестр за планом</p>
                    <input value="{{ $work->norm_semester_2_plan }}" pattern="\d+" type="text" name="norma-2-plane" required id="norma-2-plane" class="text-input">
                </label>
                <label for="count-plane">
                    <p>Кількість за планом</p>
                    <input value="{{ $work->count_plan }}" pattern="\d+" type="text" name="count-plane" required id="count-plane" class="text-input">
                </label>
                <label for="share-plane">
                    <p>Частка за планом</p>
                    <input value="{{ $work->percentage_plan }}" pattern="\d+" type="text" name="share-plane" required id="share-plane" class="text-input">
                </label>
                <label for="norma-1-fact">
                    <p>Норма на 1й семестр за фактом</p>
                    <input value="{{ $work->norm_semester_1_fact }}" pattern="\d+" type="text" name="norma-1-fact" required id="norma-1-fact" class="text-input">
                </label>
                <label for="norma-2-fact">
                    <p>Норма на 2й семестр за фактом</p>
                    <input value="{{ $work->norm_semester_2_fact }}" pattern="\d+" type="text" name="norma-2-fact" required id="norma-2-fact" class="text-input">
                </label>
                 <label for="count-fact">
                    <p>Кількість за фактом</p>
                    <input value="{{ $work->count_fact }}" pattern="\d+" type="text" name="count-fact" required id="count-fact" class="text-input">
                </label>
                <label for="share-fact">
                    <p>Частка за фактом</p>
                    <input  value="{{ $work->percentage_fact }}" pattern="\d+" type="text" name="share-fact" required id="share-fact" class="text-input">
                </label>
            </div>

            <div class="status">
                <h2>Статус: {{$work->status ? 'схвалено' : 'в очікуванні схвалення'}}</h2>
            </div>
            <div class="change-status">
                <input type="radio" id="contactChoice2"
                name="status"
                {{ $work->status ? 'checked' : null }}
                value="yes">
                <label for="contactChoice2">Схвалити</label>

                <input type="radio" id="contactChoice3"
                name="status"
                {{ !$work->status ? 'checked' : null }}
                value="no">
                <label for="contactChoice3">Перенести в статус очікування</label>
            </div>

            <div class="type-work">
                <label for="t-work">
                    <p>Тип роботи</p>
                    <select id="t-work">
                        @foreach ($type_work as $twork)
                            <option value="{{ $twork->id }}"
                        {{ $work->work->work_kind->typeWork->name_type_work == $twork->name_type_work ? 'selected' : null }}
                            >{{ $twork->name_type_work }}</option>
                        @endforeach
                    </select>
                </label>
                <label for="k-work">
                    <p>Назва виду роботи</p>
                    <select id="k-work">
                        @foreach ($work_kinds as $wkind)
                            <option value="{{ $wkind->id }}">{{ $wkind->kind_name }}</option>
                        @endforeach
                    </select>
                </label>
                <label for="ratio">
                    <p>Робота</p>
                    <select name="work" id="ratio">
                        @foreach ($works as $work1)
                            <option value="{{ $work1->id }}">{{ $work1->indicator }}</option>
                        @endforeach
                    </select>

                </label>
            </div>
        <div class="content-work">
            <label for="work-title">
                <p>Назва роботи</p>
                <input value="{{ $work->title }}" type="text" name="work-title" required id="work-title" class="text-input">
            </label>
            <p>Опис роботи</p>
            <textarea class="text-input" name="desc-work" required>{{ $work->description }}</textarea>
        </div>
        <div class="form-buttom-group">
            <input type="file" name="attachment[]" multiple/>
            <div class="group-btnff">
                <button type="submit" class="btn-submit-input">Оновити</button>
            </div>
        </div>
        @if ($work->materials)
            <p class="dop-materials">Додаткові матеріали</p>
            <table class="main-table form-work" style="display: inline-block; border: none; width: auto;">
                @foreach (json_decode($work->materials) as $item)
                <tr>
                    <td>
                    <a href="{{ URL::to($item->link) }}">{{ $item->title }}</a>
                    </td>
                </tr>
                @endforeach
            </table>
        @endif
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
