@extends('back.app')
@section('title', 'Список водителей')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Список водителей</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <a class="btn btn-success" href="{{ @url('upanel/driver/create ') }}"
                               role="button">+ Добавить</a>
                            <br> <br>
                            <input class="form-control" id="myInput" type="text" placeholder="Поиск в таблице..">
                            <br>
                            <div class="table-responsive">
                                <table class="table table-hover table-dark">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Ф.И.О.</th>
                                        <th scope="col">Таб.номер</th>
                                        <th scope="col">Гараж номер</th>
                                        <th scope="col">Авто</th>
                                        <th scope="col">Гос.номер</th>
                                        <th scope="col">Действие</th>
                                    </tr>
                                    </thead>
                                    <tbody id="myTable">
                                    @foreach($datas as $data)
                                        <tr>
                                            <th scope="row">
                                                <a href="{{ url('upanel/driver/'.$data->id .'/edit') }}">
                                                {{ $data->id }}
                                                </a>
                                            </th>
                                            <td>
                                                <a href="{{ url('upanel/driver/'.$data->id .'/edit') }}">
                                                {{ $data->name }}</a>
                                                    (<a href="{{ url('upanel/driver/log/'.$data->id) }}"
                                                    target="_blank"
                                                > лог</a>) </td>
                                            <td>{{ $data->tabelnomer }}</td>
                                            <td>{{ $data->garajnomer }}</td>
                                            <td>{{ $data->avto }}</td>
                                            <td>{{ $data->gosnomer }}</td>
                                            <td>
                                                <form method="post" action="{{ @url('upanel/driver/'. $data->id) }}">
                                                    <button type="submit" class="btn btn-danger">Удалить</button>
                                                    @method('DELETE')
                                                    @csrf
                                                </form>


                                            </td>
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
    </script>
@endsection
