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
                <h3>Изменение пункта меню</h3>
                <form action="{{route('UpdateMenu',$data['menu']->ID)}}" method="post" enctype="multipart/form-data">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <input type="hidden" name="level" id="page" value="{{$data['menu']->УровеньМеню}}">
                    <input type="hidden" name="ID" value="{{$data['menu']->ID}}">
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
                        <label for="Order">Порядок отображения</label><br>
                        <input type="text" style="width: 30rem" name="order" id="order" value="{{$data['menu']->ПорядокОтображения}}">
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
                            @isset($data['article']->КартинкаСтатьи)
                                <img src="{{$data['article']->КартинкаСтатьи}}" style="max-width:100%;height:auto;">
                            @endisset
                        </div>
                        <div class="form-group">
                            <label for="description">Введите короткий текст</label><br>
                            <textarea name="description" cols="55" rows="10" id="descriptionarticle">
                                @isset($data['article']){{$data['article']->КраткаяВерсияСтатьи}}@endisset
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="redactor">Введте текст</label><br>
                            {{csrf_field()}}
                            <textarea name="text" cols="55" rows="10" id="redactor">
                                @isset($data['article']){{$data['article']->Текст}}@endisset
                            </textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-light">Отправить</button>
                </form>
            </div>
        </div>
    </div>
@endsection