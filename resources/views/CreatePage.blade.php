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
        <div class="row" style="margin-top: 2rem; margin-bottom: 4rem;">
            <div class="col-md-2"></div>
            <div class="col-md-7" style="background: white; border: 1px solid #d7dfe3">
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
                        <label style="color: #5a6268">Добавление страницы</label>
                    </div>
                </div>
                <h3 style="margin-top: 0.6rem;">Добавление страницы</h3>
                <form action="{{route('SavePage')}}" method="post" enctype="multipart/form-data">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <input type="hidden" name="menuid" id="menuid" value="{{$data['menuid']}}">
                    <input type="hidden" name="menulang" id="menulang" value="{{$data['lang']}}">
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
