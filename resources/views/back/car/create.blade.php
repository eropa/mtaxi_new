@extends('back.app')

@section('title', 'Добавление записи(автомобиль)')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Автомобилm ( добавить запись)</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <form method="post" action="{{ @url('upanel/car') }}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Название автомобиля</label>
                                    <input class="form-control form-control-lg" type="text"
                                            name="nameAvto"
                                    >
                                </div>@csrf

                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
