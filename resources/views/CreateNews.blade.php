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
            <div class="col-md-7" style="background-color: white; border: 1px solid #d7dfe3">
                <div class="row" style="margin-top: 0.6rem; border-bottom: #5a6268 1px solid">
                    <div class="col-md-12" style="margin-left: 0.8rem">
                        @for($i = 0; $i<Count($data['menus']);$i++)
                            @if($data['menus'][$i]->Тип=='LINKS_LIST')
                                <a style="text-decoration: none; color: black" href="{{route('GetSubMenu',[$data['menus'][$i]->ID,$data['menus'][$i]->ЯзыкПодчинённого])}}">{{$data['menus'][$i]->Подчинённый}}</a>
                            @endif
                            @if($data['menus'][$i]->Тип=='FEED_LIST')
                                <a style="color: black; text-decoration: none" href="{{route('GetNews',[$data['menus'][$i]->ID,$data['menus'][$i]->ЯзыкПодчинённого])}}">{{$data['menus'][$i]->Подчинённый}}</a>
                            @endif
                            /
                        @endfor
                        <label style="color: #5a6268">Добавление статьи</label>
                    </div>
                </div>
                <h3 style="margin-top: 0.6rem; padding-bottom: 0.6rem; border-bottom: 1px solid black">Добавление статьи</h3>
                <form action="{{route('SaveNews')}}" method="post" enctype="multipart/form-data">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    @isset($data['page'])
                        <input type="hidden" name="page" id="page" value="{{$data['page']->Страница}}">
                    @endisset
                    <input type="hidden" name="language" id="language" value="{{$data['menu']->ЯзыкПодчинённого}}">
                    <input type="hidden" name="menupunct" id="menupunct" value="{{$data['menu']->Подчинённый}}">
                    <input type="hidden" name="IDMenu" value="{{$data['menu']->ID}}">
                    <div class="form-group">
                        <label for="name">Введите название</label><br>
                        <input style="width: 800px" type="text" name="name" id="name">
                    </div>
                    <div>
                        <label for="topic">Введите тему</label><br>
                        <input style="width: 800px" type="text" name="topic" id="topic">
                    </div>
                    <div class="form-group" id="imagegroup">
                        <label for="file">Загрузите фотографию</label><br>
                        <input type="file" name="image" id="image"><br>
                        <img id="imgfile" style="max-width:100%;height:auto;">
                        <input name="idimage" type="hidden" id="imgid">
                    </div>
                    <div class="form-group">
                        <label for="text">Введите короткий текст</label><br>
                        <textarea name="description" cols="92" rows="10" id="text"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="redactor">Введте текст</label><br>
                        {{csrf_field()}}
                        <textarea name="text" cols="55" rows="10" id="redactor"></textarea>
                    </div>
                    <a class="btn btn-primary" id="testbtn">Najmi</a>
                    <button type="submit" class="btn btn-light">Отправить</button>
                </form>
            </div>
        </div>
    </div>
    <div id="testing">
    </div>
@endsection
