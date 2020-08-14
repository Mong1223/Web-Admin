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
                <h3>Добавление пункта меню</h3>
                <form action="{{route('SaveMenu')}}" method="post" enctype="multipart/form-data">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    @isset($data['uppermenu'])
                        <input type="hidden" name="nameUpperMenu" value="{{$data['uppermenu']['Подчинённый']}}">
                        <input type="hidden" name="idUpperMenu" value="{{$data['uppermenu']['ID']}}">
                    @endisset
                    <input type="hidden" name="level" id="page" value="{{$data['level']}}">
                    @foreach($data['langs'] as $lang)
                        <div class="form-group">
                            <label for="name">Введите название на {{$lang->Наименование}} языке</label><br>
                            <input type="hidden" name="lang{{$lang->Наименование}}" id="lang" value="{{$lang->Наименование}}">
                            <input style="width: 30rem" type="text" name="name{{$lang->Наименование}}" id="name">
                        </div>
                    @endforeach
                    <div class="form-group" id="imagegroup">
                        <label for="file">Загрузите фотографию</label><br>
                        <input type="file" name="image" id="image"><br>
                        <img id="imgfile" style="max-width:100%;height:auto;">
                        <input name="idimage" type="hidden" id="imgid">
                    </div>
                    <div class="form-group">
                        <label for="type">Тип пункта меню</label><br>
                        <select name="type" size="1" style="width: 30rem" id="type">
                            <option value="ARTICLE">Статья</option>
                            <option value="LINK">Ссылка</option>
                            <option value="FEED_LIST" selected="selected">Список статей</option>
                            <option value="LINKS_LIST">Список пунктов меню</option>
                        </select>
                    </div>
                    <div class="form-group" id="link" style="display: none">
                        <label>Введите ссылку</label><br>
                        <input type="text" name="link" style="width: 30rem" id="linktext">
                    </div>
                    <div id="menuarticle" style="display: none;">
                            <h3>Добавление статьи на {{$lang->Наименование}} языке</h3>
                            <div class="form-group">
                                <label for="namearticle">Введите название</label><br>
                                <input style="width: 30rem" type="text" name="namearticle" id="namearticle">
                            </div>
                            <div>
                                <label for="topicarticle">Введите тему</label><br>
                                <input style="width: 30rem" type="text" name="topicarticle" id="topicarticle">
                            </div>
                            <div class="form-group" id="imagegroup">
                                <label for="file">Загрузите фотографию</label><br>
                                <input type="file" name="image" id="image"><br>
                                <img id="imgfile" style="max-width:100%;height:auto;">
                                <input name="idimage" type="hidden" id="imgid">
                            </div>
                            <div class="form-group">
                                <label for="description">Введите короткий текст</label><br>
                                <textarea name="description" cols="55" rows="10" id="descriptionarticle"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="redactor">Введте текст</label><br>
                                {{csrf_field()}}
                                <textarea name="text" cols="55" rows="10" id="redactor"></textarea>
                            </div>
                    </div>
                    <button type="submit" class="btn btn-light">Отправить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
