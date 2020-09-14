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
            <div class="col-md-7" style="background: white; border: 1px solid #d7dfe3">
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
                                    @if($data['mens'][$i]->Тип!='FEED_LIST'&&$data['mens'][$i]->Тип!='LINKS_LIST')
                                        <label style="color: #5a6268">{{$data['mens'][$i]->Подчинённый}}</label>
                                    @endif
                                    /
                                @endisset
                            @endfor
                            <label style="color: #5a6268">Редактирование</label>
                        </div>
                    </div>
                @endisset
                <h3 style="padding-top: 0.6rem; padding-bottom: 0.6rem; border-bottom: #5a6268 1px solid">Изменение пункта меню</h3>
                <form action="{{route('UpdateMenu',$data['menu']->ID)}}" method="post" enctype="multipart/form-data">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <input type="hidden" name="level" id="page" value="{{$data['menu']->УровеньМеню}}">
                    <input type="hidden" name="ID" value="{{$data['menu']->ID}}">
                    <input type="hidden" name="order" value="{{$data['menu']->ПорядокОтображения}}">
                    @isset($data['menu']->IdСтатьи)
                        <input type="hidden" name="IDArticle" value="{{$data['menu']->IdСтатьи}}">
                    @endisset
                    <div class="form-group">
                        <label for="name">Введите название</label><br>
                        <input style="width: 30rem" type="text" name="name" id="name" value="{{$data['menu']->Подчинённый}}">
                    </div>
                    @isset($data['menu']->IdРодителя)
                        <input type="hidden" name="Language" id="language" value="{{$data['menu']->Язык}}">
                    @else
                        <div class="form-group">
                            <label for="Language">Введите язык</label><br>
                            <select size="1" style="width: 30rem" name="Language">
                                @foreach($data['langs'] as $lang)
                                    <option value="{{$lang->Наименование}}">{{$lang->Наименование}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endisset
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
                        <input type="text" name="link" style="width: 30rem" id="linktext" value="@isset($data['menu']->Ссылка){{$data['menu']->Ссылка}}@endisset">
                    </div>
                    <div id="menuarticle" style="display: none;">
                        <h3>Добавление статьи</h3>
                        <div class="form-group">
                            <label for="namearticle">Введите название</label><br>
                            <input style="width: 30rem" type="text" name="namearticle" id="namearticle" value="@isset($data['article']){{$data['article']->Название}}@endisset">
                        </div>
                        <div>
                            <label for="topicarticle">Введите тему</label><br>
                            <input style="width: 30rem" type="text" name="topicarticle" id="topicarticle" value="@isset($data['article']){{$data['article']->Тематика}}@endisset">
                        </div>
                        <div class="form-group" id="imagegroup">
                            <label for="file">Загрузите фотографию</label><br>
                            <input type="file" name="image" id="image">
                            <img id="imgfile" style="max-width:100%;height:auto;">
                            <input name="idimage" type="hidden" id="imgid" src="@isset($data['article']->КартинкаСтатьи)https://internationals.tpu.ru:8080/api/media/img/{{$data['article']->КартинкаСтатьи}}@endisset">
                        </div>
                        <div class="form-group">
                            <label for="description">Введите короткий текст</label><br>
                            <textarea name="description" cols="55" rows="10" id="descriptionarticle">@isset($data['article']){{$data['article']->КраткаяВерсия}}@endisset</textarea>
                        </div>
                        <div class="form-group">
                            <label for="redactor">Введте текст</label><br>
                            {{csrf_field()}}
                            <textarea name="text" cols="55" rows="10" id="redactor">@isset($data['article']){{$data['article']->Текст}}@endisset</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-light">Отправить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
