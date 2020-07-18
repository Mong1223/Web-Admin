@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        @if($errors->any())
            <div class="alert alert-danger" style="margin-top: 4.6rem">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row" style="margin-top: 2rem; margin-bottom: 4rem">
            <div class="col-md-2"></div>
            <div class="col-md-6">
                <h3>Добавление страницы</h3>
                <form action="{{route('SavePage')}}" method="post" enctype="multipart/form-data">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <input type="hidden" name="Menu" id="Menu" value="{{$Menu}}">
                    <div class="form-group">
                        {{csrf_field()}}
                        <label for="name">Введите название</label><br>
                        <input style="width: 30rem" type="text" name="name" id="name">
                    </div>
                    <button type="submit" class="btn btn-light">Отправить</button>
                </form>
            </div>
        </div>
    </div>
    <div id="testing">
    </div>
@endsection
