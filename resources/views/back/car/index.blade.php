@extends('back.app')

@section('title', 'Список автомобилей')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Автомобили</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        Список автомобилей <a class="btn btn-success" href="{{ @url('upanel/car/create ') }}"
                                              role="button">+ Добавить</a>
                            <HR>

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Название</th>
                                    <th scope="col">Действие</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($datas as $data)
                                    <tr>
                                        <th scope="row">{{ $data->id }}</th>
                                        <td><a href="{{ url('upanel/car/'.$data->id.'/edit') }}" >
                                                {{ $data->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <form method="post" action="{{ @url('upanel/car/'. $data->id) }}">
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
