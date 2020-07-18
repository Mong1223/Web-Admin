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
                <h3>Добавление статьи</h3>
                <form action="{{route('SaveNews')}}" method="post" enctype="multipart/form-data">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    @isset($data['page'])
                        <input type="hidden" name="page" id="page" value="{{$data['page']['Страница']}}">
                    @endisset
                    <input type="hidden" name="language" id="language" value="{{$data['menu']['ЯзыкПодчинённого']}}">
                    <input type="hidden" name="menupunct" id="menupunct" value="{{$data['menu']['Подчинённый']}}">
                    <input type="hidden" name="IDMenu" value="{{$data['menu']['ID']}}">
                    <div class="form-group">
                        <label for="name">Введите название</label><br>
                        <input style="width: 30rem" type="text" name="name" id="name">
                    </div>
                    <div>
                        <label for="topic">Введите тему</label><br>
                        <input style="width: 30rem" type="text" name="topic" id="topic">
                    </div>
                    <div class="form-group">
                        <label for="text">Введите короткий текст</label><br>
                        <textarea name="description" cols="55" rows="10" id="text"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="redactor">Введте текст</label><br>
                        {{csrf_field()}}
                        <textarea name="text" cols="55" rows="10" id="redactor"></textarea>
                    </div>
                    <button type="submit" class="btn btn-light">Отправить</button>
                </form>
            </div>
        </div>
    </div>
    <div id="testing">
    </div>
@endsection
