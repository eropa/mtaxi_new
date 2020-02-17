@extends('back.app')

@section('title', 'Редактировать запись(автомобиль)')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Автомобилm ( добавить запись)</div>
                    <div class="card-body">
                        <form method="POST" action="{{ url('upanel/car/'.$data->id) }}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Название автомобиля</label>
                                <input class="form-control form-control-lg" type="text"
                                       name="nameAvto"
                                       value="{{ $data->name }}"
                                >
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
