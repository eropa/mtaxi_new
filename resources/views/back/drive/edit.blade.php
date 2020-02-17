@extends('back.app')

@section('title', 'Добавление записи(водителя)')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Водитель ( редактировать запись)</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="post" action="{{ @url('upanel/driver/'.$data->id) }}">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Табельный номер</label>
                                    <input type="text"
                                           class="form-control"
                                           id="tabelnomer"
                                           placeholder="Табельный номер"
                                           readonly
                                           value="{{ $data->tabelnomer }}"
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
                                           value="{{ $data->garajnomer }}"
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
                                           value="{{ $data->name }}"
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
                                           value="{{ $data->fiosmal }}"
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
                                           placeholder="автомобиль"
                                           value="{{ $data->avto }}"
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
                                           oninput="mySelectGosNomer()"
                                           value="{{ $data->gosnomer }}"
                                    >
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Фирма</label>
                                    <select class="js-example-basic-single" name="firmaid">
                                        <option value="0">Выбирите фирму</option>
                                        @foreach($datafirms as $datafirm)
                                            <option value="{{ $datafirm->id }}"
                                                @if($datafirm->id==$data->firmaid)
                                                    selected
                                                @endif
                                            >{{ $datafirm->name }}</option>
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
                                           oninput="mySelectRegNomer()"
                                           value="{{ $data->regnomer1 }}"
                                    >
                                </div>
                                <div class="form-group col-md-2">
                                    <label>*</label>
                                    <input type="text"
                                           class="form-control"
                                           name="regnomer2"
                                           value="{{ $data->regnomer2 }}"
                                    >
                                </div>
                                <div class="form-group col-md-5">
                                    <label>*</label>
                                    <input type="text"
                                           class="form-control"
                                           name="regnomer3"
                                           value="{{ $data->regnomer3 }}"
                                    >
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Удостоверение</label>
                                    <input type="text"
                                           class="form-control"
                                           name="ydost1"
                                           value="{{ $data->ydost1 }}"
                                    >
                                </div>
                                <div class="form-group col-md-6">
                                    <label>*</label>
                                    <input type="text"
                                           class="form-control"
                                           name="ydost2"
                                           value="{{ $data->ydost2 }}"
                                    >
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Телефон</label>
                                    <input type="text"
                                           class="form-control"
                                           name="phonedrive"
                                           value="{{ $data->phonedrive }}"
                                    >
                                </div>

                            </div>

                            @method('PUT')
                            @csrf
                            <button type="submit" class="btn btn-primary">Обновить</button>
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


        function mySelectRegNomer(){
            var input = document.getElementById("regnomer");
            var inputgarj = document.getElementById("tabelnomer");
            inputgarj.value=parseInt(input.value.replace(/\D+/g,""));
        }
    </script>

@endsection
