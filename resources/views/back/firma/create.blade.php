@extends('back.app')

@section('title', 'Добавление записи(фимры)')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Фирма ( добавить запись)</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <form method="post" action="{{ @url('upanel/firma') }}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Название фирмы</label>
                                    <input class="form-control form-control-lg" type="text"
                                            name="name"
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Номер фирмы</label>
                                    <input class="form-control form-control-lg" type="text"
                                           name="nomerorganiz"
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Адресс фирмы</label>
                                    <input class="form-control form-control-lg" type="text"
                                           name="address"
                                    >
                                </div>

                                @csrf
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('myjs')


@endsection
