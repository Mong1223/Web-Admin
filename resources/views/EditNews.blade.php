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
                <h3>Редактирование статьи</h3>
                <form action="{{route('UpdateNews',$data->IdСтатьи)}}" method="post" enctype="multipart/form-data">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <input type="hidden" value="{{$data->ПунктМеню}}" name="menupunct">
                    <div class="form-group">
                        <label for="name">Введите название</label><br>
                        <input value="{{$data->НазваниеСтатьи}}" style="width: 30rem" type="text" name="name" id="name">
                    </div>
                    <div>
                        <label for="topic">Введите тему</label><br>
                        <input value="{{$data->Тематика}}" style="width: 30rem" type="text" name="topic" id="topic">
                    </div>
                    <div class="form-group" id="imagegroup">
                        <label for="file">Загрузите фотографию</label><br>
                        <input type="file" name="image" id="image"><br>
                        <img id="imgfile" style="max-width:100%;height:auto;">
                        <input name="idimage" src="@isset($data->Картинка)http://109.123.155.178:8080/api/media/img/{{$data->Картинка}}@endisset" type="hidden" id="imgid">
                    </div>
                    <div class="form-group">
                        <label for="text">Введите короткий текст</label><br>
                        <textarea name="description" cols="55" rows="10" id="text">{{$data->КраткаяВерсия}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="redactor">Введте текст</label><br>
                        {{csrf_field()}}
                        <textarea name="text" cols="55" rows="10" id="redactor">{{$data->ТекстСтатьи}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-light">Отправить</button>
                </form>
            </div>
        </div>
    </div>
    <div id="testing">
    </div>
@endsection
