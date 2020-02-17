@extends('back.app')

@section('title', 'Добавление записи(водителя)')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Водитель ( добавить запись)</div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="post" action="{{ @url('upanel/driver') }}"  onsumbit="myfunc()" >
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Табельный номер</label>
                                    <input type="text"
                                           class="form-control"
                                           id="tabelnomer"
                                           placeholder="Табельный номер"
                                           readonly
                                           name="tabelnomer"
                                    >
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Гараж номер</label>
                                    <input type="text"
                                           class="form-control"
                                           id="garajnomer"
                                           placeholder="Гараж номер"
                                           readonly
                                           name="garajnomer"
                                    >
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Ф.И.О. полностью</label>
                                    <input type="text"
                                           class="form-control"
                                           id="inputFio"
                                           placeholder="Ф.И.О. полностью"
                                           name="name"
                                           required
                                           oninput="mySelectFio()"
                                    >
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Ф.И.О коротко</label>
                                    <input type="text"
                                           class="form-control"
                                           id="inputfiosmal"
                                           placeholder="Ф.И.О коротко"
                                           readonly
                                           name="fiosmal"
                                    >
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Автомобиль</label>
                                    <input type="text"
                                           class="form-control"
                                           id="inputAvto"
                                           required
                                           placeholder="автомобиль"
                                           name="avto"
                                    >
                                </div>
                                <div class="form-group col-md-6">
                                    <label>База автомобилей</label>
                                    <select multiple class="form-control" id="selecCars" ondblclick="myFunctionDbl()">
                                        @foreach($datacars as $datacar)
                                            <option>{{ $datacar->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Гос.номер</label>
                                    <input type="text"
                                           class="form-control"
                                           id="gosnomer"
                                           placeholder="гос.номер"
                                           name="gosnomer"
                                           required
                                           oninput="mySelectGosNomer()"
                                    >
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Фирма</label>
                                    <button type="button" class="btn btn-primary" onclick="ajaxFirma()">Обновить список</button>
                                    <a href="{{ @url('upanel/firma/create') }}" target="_blank">Добавить фирму</a>
                                    <select  class="js-example-basic-single" name="firmaid" id="firmaid" >
                                        <option value="0">Выберите фирму</option>
                                        @foreach($datafirms as $datafirm)
                                            <option value="{{ $datafirm->id }}">{{ $datafirm->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label>Рег.номер</label>
                                    <input type="text"
                                           class="form-control"
                                           id="regnomer"
                                           name="regnomer1"
                                           required
                                           oninput="mySelectRegNomer()"
                                    >
                                </div>
                                <div class="form-group col-md-2">
                                    <label>*</label>
                                    <input type="text"
                                           class="form-control"
                                           name="regnomer2"
                                           value="МО"
                                           required
                                    >
                                </div>
                                <div class="form-group col-md-5">
                                    <label>*</label>
                                    <input type="text"
                                           required
                                           class="form-control"
                                           name="regnomer3"
                                    >
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Удостоверение</label>
                                    <input type="text"
                                           required
                                           class="form-control"
                                           name="ydost1"
                                    >
                                </div>
                                <div class="form-group col-md-6">
                                    <label>*</label>
                                    <input type="text"
                                           required
                                           class="form-control"
                                           name="ydost2"
                                    >
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Телефон</label>
                                    <input type="text"
                                           class="form-control"
                                           name="phonedrive"
                                    >
                                </div>

                            </div>


                            @csrf
                            <button type="submit" class="btn btn-primary"

                            >Добавить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('myjs')
    <script>

        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        /**
         * Функция выбора авто из шаблона
         */
        function myFunctionDbl(){
            var select = document.getElementById("selecCars");
            var value =select.value;
            var avtoInput=document.getElementById("inputAvto");
            avtoInput.value=value;
        }


        /**
         * Получение короткого фио
         */
        function mySelectFio(){
            var input = document.getElementById("inputFio");
            var sinput = document.getElementById("inputfiosmal");
            arr = input.value.split(' ')

            sinput.value="";
            var i=0;
            sinput.value=arr[0];
            arr.forEach(function(element) {
                if(i!=0){
                    sinput.value+=" "+element.charAt(0)+".";
                }
                i++;
            });
        }

        /**
         * Получаем гаражный номер
         */
        function mySelectGosNomer(){
            var input = document.getElementById("gosnomer");
            var inputgarj = document.getElementById("garajnomer");
            inputgarj.value=parseInt(input.value.replace(/\D+/g,""));
        }


        /**
         * Получаем регистрационный номер
         */
        function mySelectRegNomer(){
            var input = document.getElementById("regnomer");
            var inputgarj = document.getElementById("tabelnomer");
            inputgarj.value=parseInt(input.value.replace(/\D+/g,""));
        }

        function ajaxFirma(){
            // выбираем по id
            var selectElement = document.getElementById('firmaid');
            selectElement.innerHTML = '';
            //
            var option = document.createElement("option");
            option.text = "Выберите фирму";
            selectElement.add(option);
            // теперь груим ajax
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var myObj = JSON.parse(this.responseText);
                    alert(myObj);
                    myObj.forEach(function(element) {
                        var option = document.createElement("option");
                        option.value=element[0];
                        option.text = element[1];
                        selectElement.add(option);
                    });
                    //document.getElementById("demo").innerHTML = myObj.name;
                }
            };
            var sUrl="{{@url('upanel/updatefirma')}}";
            xmlhttp.open("GET", sUrl, true);
            xmlhttp.send();
        }

    </script>

@endsection
