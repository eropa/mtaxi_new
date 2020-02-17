@extends('back.app')

@section('title', 'Список cотрудников')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Сотрудник</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        Список сотрудников
                        <HR>

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Должность</th>
                                <th scope="col">Ф.И.О.</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($datas as $data)
                                <tr>
                                    <th scope="row">{{ $data->id }}</th>
                                    <td>
                                        <a href="{{ url('upanel/cotrudnik/'.$data->id.'/edit') }}" >
                                            {{ $data->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $data->fio }}
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
