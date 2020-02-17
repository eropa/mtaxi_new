@extends('back.app')

@section('title', 'Редактировать записи(сотрудник)')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Сотрудник ( редактировать запись)</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <form method="POST" action="{{ url('upanel/cotrudnik/'.$data->id) }}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Должность</label>
                                <input class="form-control form-control-lg" type="text"
                                       name="name"
                                       value="{{ $data->name }}"
                                       readonly
                                >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ф.И.О.</label>
                                <input class="form-control form-control-lg" type="text"
                                       name="fio"
                                       value="{{ $data->fio }}"
                                >
                            </div>

                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary">Обновить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
