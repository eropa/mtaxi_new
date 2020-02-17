@extends('back.app')

@section('title', 'Редактировать записи(фимры)')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Фирма ( редактировать запись)</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <form method="POST" action="{{ url('upanel/firma/'.$data->id) }}"
                                 >
                            <div class="form-group">
                                <label for="exampleInputEmail1">Название фирмы</label>
                                <input class="form-control form-control-lg" type="text"
                                       name="name"
                                       value="{{ $data->name }}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Номер фирмы</label>
                                <input class="form-control form-control-lg" type="text"
                                       name="nomerorganiz"
                                       value="{{ $data->nomerorganiz }}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Адресс фирмы</label>
                                <input class="form-control form-control-lg" type="text"
                                       name="address"
                                       value="{{ $data->address }}"
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


