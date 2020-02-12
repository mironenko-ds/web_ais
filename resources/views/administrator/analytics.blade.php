@extends('administrator.layout.template')
@section('title', $dep_name)
@section('content')
    <div class="page__title">
        <a href="#">Головна</a>
        <img src="{{ asset('img/next.png') }}" alt="next">
        <a href="#">{{$dep_name}}</a>
    </div>
    <div class="user_offer block-no-padding" style="margin-top: 30px;margin-bottom: 10px; max-width: 1200px;">
        <div class="header">
            <div class="header-item analitic-item">
                @if ($isSelected)
                <p class="btn-tab" data-tab="1">Кількість робіт</p>
                @else
                <p class="btn-tab selected" data-tab="1">Кількість робіт</p>
                @endif
            </div>
            <div class="header-item analitic-item">
                @if ($isSelected)
                <p  class="btn-tab selected" data-tab="2">Кількісні характеристики</p>
                @else
                <p  class="btn-tab" data-tab="2">Кількісні характеристики</p>
                @endif
            </div>
        </div>
        <div class="analitic-items">
            <div class="info-item">
                <div class="title">
                    <h2>
                        Кількість робіт <br>на кафедрі
                    </h2>
                </div>
                <div class="count">
                    {{$count_work}}
                </div>
            </div>
            <div class="info-item">
                <div class="title">
                    <h2>
                        Кількість працівникі<br> на кафедрі
                    </h2>
                </div>
                <div class="count">
                    {{$count_people}}
                </div>
            </div>
            <div class="info-item">
                <div class="title">
                    <h2>
                        Кількість заявок <br>на реєстрацію
                    </h2>
                </div>
                <div class="count">
                    {{$count_req}}
                </div>
            </div>
        </div>
            @if ($isSelected)
            <div class="tab-content" data-tab="1">
            @else
            <div class="tab-content show" data-tab="1">
            @endif
            <div class="graph-count-user">
                <canvas id="dateWork"></canvas>
            </div>
            <div class="date-search-user">
                <form action="" style="align-items: flex-end;">
                    @isset($employees[0])
                    <label for="">
                        <p>Співробітник кафедри</p>
                        <select name="user" class="text-input" style="margin-right:20px">
                            @foreach ($employees as $item)
                                <option value="{{$item->id}}">{{$item->name . ' ' . $item->surname}}</option>
                            @endforeach
                        </select>
                    </label>
                    @endisset
                    <label for="val-date-1">
                        <p>від</p>
                        <input class="padding-right text-input" type="date" min="{{$old_date}}" value="{{$old_date}}"  name="val-date-1" id="val-date-1">
                    </label>
                    <label for="val-date-2">
                        <p>до</p>
                        <input type="date" class="text-input" name="val-date-2"  max="{{$max_date}}" id="val-date-2">
                    </label>
                        <input type="submit" id="sendDate" class="btn-submit-input" value="Обновити" style="margin-left: 10px; height: 38px;">
                </form>
            </div>

        </div>
            @if ($isSelected)
            <div class="tab-content show" data-tab="2">
            @else
            <div class="tab-content" data-tab="2">
            @endif
            <div class="wrapped-bar">
                <div class="graph-count-user">
                    <canvas id="WorksArea"></canvas>
                </div>
            </div>
            @isset($employees[0])
            <div class="form-moder" style="margin:20px">
                <form action="">
                    <label for="">
                        <p>Співробітник кафедри</p>
                        <select name="user-area" class="text-input" style="margin-right:20px">
                            @foreach ($employees as $item)
                                <option
                                value="{{$item->id}}">{{$item->name . ' ' . $item->surname}}</option>
                            @endforeach
                        </select>
                    </label>
                    <input type="text" name="select" value="ok" id="" hidden>
                        <input type="submit" id="sendDate" class="btn-submit-input" value="Обновити">
                </form>
            </div>
            @endisset
        </div>
    </div>
    <div class="hide-block" style="display:none">
        @foreach ($resultDateFirst as $item)
            <div class="moutDateFirst">
                {{$item->mn}}
            </div>
            <div class="countDateFirst">
                {{$item->cont}}
            </div>
        @endforeach

        @foreach ($type_work_count as $key => $value)
            <div class="keysWork">
                {{$key}}
            </div>
            <div class="valueWork">
                {{$value}}
            </div>
        @endforeach
    </div>
@endsection
@section('scriptUser')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" defer></script>
    <script src="{{ asset('js/graph.min.js') }}" defer></script>
@endsection


@section('script')
<script defer>
    var tabBtn = document.querySelectorAll('.btn-tab');
    var tabContent = document.querySelectorAll('.tab-content');

    tabBtn.forEach(function(item){
        item.addEventListener('click', function(){
           var btnData = this.getAttribute('data-tab');
           clearClassContent();
           ViewTabChagne(btnData);
           // пункты меню
           clearBtn();
           item.classList.add('selected');

        });
    });

    function ViewTabChagne(btnDate){
        tabContent.forEach(function(item){
                var viewData = item.getAttribute('data-tab');
               if(btnDate == viewData){
                   item.classList.add('show');
               }
            });
    }


    function clearClassContent(){
        tabContent.forEach(function(item){
            item.classList.remove('show');
            });
    }
    function clearBtn(){
        tabBtn.forEach(function(item){
            item.classList.remove('selected');
    });
    }

    var allMn = document.querySelectorAll('.moutDateFirst');
    var allMnData = document.querySelectorAll('.countDateFirst');

    var objMn = {
        '1': 'Січень',
        '2': 'Лютий',
        '3': 'Березень',
        '4': 'Квітень',
        '5': 'Травень',
        '6': 'Червень',
        '7': 'Липень',
        '8': 'Серпень',
        '9': 'Вересень',
        '10': 'Жовтень',
        '11': 'Листопад',
        '12': 'Грудень'
    }

    function getallMnData(){
        array = [];

        allMnData.forEach(function(item){
            array.push(item.innerHTML);
        });

        return array;
    }


    function setMn(){
        array = [];
        allMn.forEach(function(item){
            for(key in objMn){

                if(key == +item.innerHTML){
                    array.push(objMn[key]);
                }
            }
        });
        return array;
    }
    console.log(getallMnData());
    var MONTHS = ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'];
var configUserDate = {
    type: 'line',
    data: {
        labels: setMn(),
        datasets: [{
            label: 'Роботи',
            fill: false,
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: getallMnData(),
        }]
    },
    options: {
        responsive: true,
        title: {
            display: true,
            text: 'За період'
        },
        tooltips: {
            mode: 'index',
            intersect: false,
        },
        hover: {
            mode: 'nearest',
            intersect: true
        },
        scales: {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'місяць'
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'кількість робіт'
                }
            }]
        }
    }
};



var randomScalingFactor = function() {
    return Math.round(Math.random() * 100);
};

var keysWork = document.querySelectorAll('.keysWork');
var valueWork = document.querySelectorAll('.valueWork');

function getAllKeys(){
    array = [];
    keysWork.forEach(function(item){
        array.push(item.innerHTML);
    });
    return array;
}

function getValue(){
    array = [];
    valueWork.forEach(function(item){
        array.push(item.innerHTML);
    });
    return array;
}

function generateColors(){
    array = [];

    for(i = 0; i < keysWork.length; i++){
        array.push('#' + Math.floor(Math.random()*16777215).toString(16));
    }
    return array;
}

var chartColors = {
    red: "rgb(255, 99, 132)",
    orange: "rgb(255, 159, 64)",
    yellow: "rgb(255, 205, 86)",
    green: "rgb(75, 192, 192)",
    blue: "rgb(54, 162, 235)",
    purple: "rgb(153, 102, 255)",
    grey: "rgb(201, 203, 207)"
}

var configPolar = {
    type: 'polarArea',
    data: {
        datasets: [{
            data: getValue(),
            backgroundColor: generateColors(),
            label: 'My dataset' // for legend
        }],
        labels: getAllKeys()
    },
    options: {
        responsive: true,
        legend: {
            position: 'right',
        },
        title: {
            display: true,
            text: 'За типом виконуваної роботи'
        },
        scale: {
            ticks: {
                beginAtZero: true
            },
            reverse: false
        },
        animation: {
            animateRotate: false,
            animateScale: true
        }
    }
};



window.onload = function() {

    var dateWork = document.getElementById('dateWork').getContext('2d');
    var myPolarArea = document.getElementById('WorksArea').getContext('2d');
    new Chart(myPolarArea, configPolar);
    new Chart(dateWork, configUserDate);
};



</script>
@endsection
