@extends('back.app')
@section('title', 'формирование путевых листов')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">формирование путевых листов</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <input class="form-control" id="myInput" type="text" placeholder="Поиск в таблице..">
                            <br>
                            <button type="button" class="btn btn-warning"  onclick="btPrintCheck()">
                                Открыть только выбраные фамилии
                            </button>
                            <br>

                        <div class="table-responsive">
                            <table class="table table-hover table-dark">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ф.И.О.</th>
                                    <th scope="col" >Таб.номер</th>
                                    <th scope="col">Гараж номер</th>
                                    <th scope="col">Авто</th>
                                    <th scope="col">Гос.номер</th>
                                    <th scope="col">Действие</th>
                                </tr>
                                </thead>
                                <tbody id="myTable">
                                @foreach($datas as $data)
                                    <tr>
                                        <th scope="row">{{ $data->id }}
                                            <br>
                                        </th>
                                        <td><input class="form-check-input"
                                                   type="checkbox"
                                                   value="{{ $data->id }}"
                                                   id="defaultCheck_{{ $data->id }}">
                                            {{ $data->name }}

                                            </a>
                                            (<a href="{{ url('upanel/driver/log/'.$data->id) }}"
                                                target="_blank"
                                            > лог</a>) </td>
                                        <td>{{ $data->tabelnomer }}</td>
                                        <td>{{ $data->garajnomer }}</td>
                                        <td>{{ $data->avto }}</td>
                                        <td>{{ $data->gosnomer }}</td>
                                        <td>
                                            <form method="post">
                                                с  <input type="date" id="start{{$data->id}}" name="trip-start"> <br>
                                                по <input type="date" id="end{{$data->id}}" name="trip-end"><br>
                                                <input type="hidden" name="id_" value="{{$data->id}}">
                                            </form>

                                        <button type="button" class="btn btn-primary" onclick="btClick({{$data->id}})">
                                            Сформировать отдельно
                                        </button>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('myjs')
    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        /**
         * Открываем страницу для сохранения документа
         * @param id
         */
        function btClick(id){
            // получаем дату
            elementstart = document.getElementById("start"+id).value;
            elementend = document.getElementById("end"+id).value;
            // переменая для открытия
            var sUrl="{{@url('upanel/pdf/')}}/"+id+"/"+elementstart+"/"+elementend;
            // // октрываем страницу
           window.open(sUrl,'_blank');
        }


        /**
         * Открываем в новой странице путевые листы
         */
        function btPrintCheck(){


            var array = [];
            var checkboxes = document.querySelectorAll('input[type=checkbox]:checked');

            for (var i = 0; i < checkboxes.length; i++) {
                array.push(checkboxes[i].value);
              //  alert(checkboxes[i].value);
                btClick(checkboxes[i].value);
            }


        }
    </script>
@endsection
