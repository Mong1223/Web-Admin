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
            <div class="col-md-7" style="background: white; border: #d7dfe3 1px solid">
                @isset($data['mens'])
                    <div class="row" style="border-bottom: #5a6268 1px solid; background-color: white">
                        <div class="col-md-12" style="margin-top: 0.6rem;">
                            @for($i=0; $i<Count($data['mens']);$i++)
                                @isset($data['mens'][$i])
                                    @if($data['mens'][$i]->Тип=='LINKS_LIST')
                                        <a style="text-decoration: none; color: black" href="{{route('GetSubMenu',[$data['mens'][$i]->ID,$data['mens'][$i]->ЯзыкПодчинённого])}}">{{$data['mens'][$i]->Подчинённый}}</a>
                                    @endif
                                    @if($data['mens'][$i]->Тип=='FEED_LIST')
                                        <a style="color: black; text-decoration: none" href="{{route('GetNews',[$data['mens'][$i]->ID,$data['mens'][$i]->ЯзыкПодчинённого])}}">{{$data['mens'][$i]->Подчинённый}}</a>
                                    @endif
                                    /
                                @endisset
                            @endfor
                            <label style="color: #5a6268">Пункты меню</label>
                        </div>
                    </div>
                @endisset
                <h3 style="padding-top: 0.6rem; padding-bottom: 0.6rem; border-bottom: #5a6268 1px solid">Добавление пункта меню</h3>
                <form action="{{route('SaveMenu')}}" method="post" enctype="multipart/form-data">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    @isset($data['uppermenu'])
                        <input type="hidden" name="nameUpperMenu" value="{{$data['uppermenu']->Подчинённый}}">
                        <input type="hidden" name="idUpperMenu" value="{{$data['uppermenu']->ID}}">
                    @endisset
                    <input type="hidden" name="level" id="page" value="{{$data['level']}}">
                    <div class="form-group">
                        <label for="name">Введите название</label><br>
                        <input class="form-control" type="text" name="name" id="name">
                    </div>
                    @isset($data['uppermenu']->ЯзыкПодчинённого)
                        <input type="hidden" name="Language" id="language" value="{{$data['uppermenu']->ЯзыкПодчинённого}}">
                    @else
                        <div class="form-group">
                            <label for="Language">Введите язык</label><br>
                            <select class="form-control" size="1" name="Language">
                                @foreach($data['langs'] as $lang)
                                    <option value="{{$lang->Наименование}}">{{$lang->Наименование}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endisset
                    <div class="form-group" id="imagegroup">
                        <label for="file">Загрузите фотографию</label><br>
                        <input class="form-control" type="file" name="image" id="image"><br>
                        <img id="imgfile" style="max-width:100%;height:auto;">
                        <input class="form-control" name="idimage" type="hidden" id="imgid">
                    </div>
                    <div class="form-group">
                        <label for="type">Тип пункта меню</label><br>
                        <select class="form-control" name="type" size="1" id="type">
                            <option value="ARTICLE">Статья</option>
                            <option value="LINK">Ссылка</option>
                            <option value="FEED_LIST" selected="selected">Список статей</option>
                            <option value="LINKS_LIST">Список пунктов меню</option>
                        </select>
                    </div>
                    <div class="form-group" id="link" style="display: none">
                        <label>Введите ссылку</label><br>
                        {{csrf_field()}}
                        <input class="form-control" type="text" name="link" id="linktext">
                    </div>
                    <div id="menuarticle" style="display: none;">
                        <h3>Добавление статьи</h3>
                        <div class="form-group">
                            <label for="namearticle">Введите название</label><br>
                            <input class="form-control" type="text" name="namearticle" id="namearticle">
                        </div>
                        <div>
                            <label for="topicarticle">Введите тему</label><br>
                            <input class="form-control" type="text" name="topicarticle" id="topicarticle">
                        </div>
                        <div class="form-group" id="imagegroup">
                            <label for="file">Загрузите фотографию</label><br>
                            <input class="form-control" type="file" name="image" id="image">
                            <img id="imgfile" style="max-width:100%;height:auto;">
                            <input class="form-control" name="idimage" type="hidden" id="imgid">
                        </div>
                        <div class="form-group">
                            <label for="description">Введите короткий текст</label><br>
                            <textarea class="form-control" name="description" id="descriptionarticle"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="redactor">Введте текст</label><br>
                            {{csrf_field()}}
                            <textarea class="form-control" name="text" id="redactor"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-light">Отправить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
