@extends('back.app')

@section('title', 'Список фирм')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Фирмы</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        Список автомобилей <a class="btn btn-success" href="{{ @url('upanel/firma/create ') }}"
                                              role="button">+ Добавить</a>
                        <HR>

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Название</th>
                                <th scope="col">Номер организации</th>
                                <th scope="col">Адресс организации</th>
                                <th scope="col">Действие</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($datas as $data)
                                <tr>
                                    <th scope="row">{{ $data->id }}</th>
                                    <td>
                                        <a href="{{ url('upanel/firma/'.$data->id.'/edit') }}" >
                                            {{ $data->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $data->nomerorganiz }}
                                    </td>
                                    <td>
                                        {{ $data->address }}
                                    </td>


                                    <td>
                                        <form method="post" action="{{ @url('upanel/firma/'. $data->id) }}">
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
@endsection
