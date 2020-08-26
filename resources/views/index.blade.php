@extends('layouts.master')
@section('content')
    <div class="container-fluid" style="margin-bottom: 1rem">
        <div class="row" style="margin-bottom: 2rem">
            <nav id="content-nav" class="col-md-1 d-md-block sidebar sidebar-little">
                <div class="sidebar-sticky d-none" style="margin-top: 1rem" id="sidebar-content">
                    <ul class="nav flex-column">
                        @for($i=0;$i<Count($data['menu']);$i++)
                             <li class="row row-nav" style="height: auto">
                                 <div class="nav-item col-md-8" style="cursor: pointer">
                                    @if($data['menu'][$i]->Тип=='FEED_LIST')
                                        <a href="{{route('GetNews', [$data['menu'][$i]->ID,$data['menu'][$i]->ЯзыкПодчинённого])}}" style="text-decoration: none;">
                                            {{$data['menu'][$i]->Подчинённый}}
                                           </a>
                                    @else
                                        @if($data['menu'][$i]->Тип=='LINKS_LIST')
                                            <a href="{{route('GetSubMenu',[$data['menu'][$i]->ID,$data['menu'][$i]->ЯзыкПодчинённого])}}" style="text-decoration: none">
                                                {{$data['menu'][$i]->Подчинённый}}
                                            </a>
                                        @else
                                            {{$data['menu'][$i]->Подчинённый}}
                                        @endif
                                    @endif
                                 </div>
                                 <a class="col-md-2 close" style="color: white" href="{{route('DeleteMenu',$data['menu'][$i]->ID)}}" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </a>
                                 <a class="col-md-2" style="margin-top: 0.2rem" href="{{route('EditMenu',$data['menu'][$i]->ID)}}">
                                     <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="white" xmlns="http://www.w3.org/2000/svg">
                                         <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                         <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                     </svg>
                                 </a>
                             </li>
                        @endfor
                        <a href="{{route('CreateUpMenu')}}" class="btn btn-primary" style="margin-bottom: 0.2rem; margin-left: 0.5rem; margin-right: 0.5rem">
                            Добавить пункт меню
                        </a>
                    </ul>
                </div>
            </nav>
            <main id="main" role="main" class="col-md-11 ml-sm-auto pt-3 px-4">
                <div class="row header-content">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-1" style="margin-top: 1.4rem">
                                <img class="avatarca" src="\images\f1.png" alt="">
                            </div>
                            <div class="col-md-11" style="margin-top: 1.4rem">
                                <h3>Добро пожаловать Администратор</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="menu-content" style="background-color: white">
                    @isset($data['menus'])
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
                        <div class="row" style="background-color: white">
                            <h3 style="margin-top: 1rem; margin-left: 1rem">Пункты меню</h3>
                        </div>
                        @for($i=0;$i<Count($data['menus']);$i+=3)
                            <div class="row" style="background-color: white">
                                @for($j=0;$j<3;$j++)
                                    @isset($data['menus'][$i+$j]->Подчинённый)
                                        <div class="col-md-4">
                                            @if($data['menus'][$i+$j]->Тип=='FEED_LIST')
                                                <a href="{{route('GetNews',[$data['menus'][$i+$j]->ID,$data['menus'][$i+$j]->ЯзыкПодчинённого])}}" style="color: #1b1e21; text-decoration: none">
                                                    <div style="border: 1px solid #d7dfe3; margin-bottom: 2rem">
                                                        <img style="width: 100%; height: 70%" src="/images/fon{{rand(1,5)}}.jpg" alt="">
                                                        <h5 style="margin-top: 0.6rem;margin-left: 0.4rem;margin-bottom: 1rem">{{$data['menus'][$i+$j]->Подчинённый}}</h5>
                                                        <div class="row" style="margin-bottom: 0.6rem">
                                                            <div class="col-md-1"></div>
                                                            <a class="btn btn-primary col-md-4" href="{{route('EditMenu',$data['menus'][$i+$j]->ID)}}">
                                                                Редактировать
                                                            </a>
                                                            <div class="col-md-2"></div>
                                                            <a class="btn btn-primary col-md-4" href="{{route('DeleteMenu',$data['menus'][$i+$j]->ID)}}">
                                                                Удалить
                                                            </a>
                                                            <div class="col-md-1"></div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif
                                            @if($data['menus'][$i+$j]->Тип=='LINKS_LIST')
                                                <a href="{{route('GetSubMenu',[$data['menus'][$i+$j]->ID,$data['menus'][$i+$j]->ЯзыкПодчинённого])}}" style="color: #1b1e21; text-decoration: none">
                                                    <div style="border: 1px solid #d7dfe3; margin-bottom: 2rem">
                                                        <img style="width: 100%; height: 70%" src="/images/fon{{rand(1,5)}}.jpg" alt="">
                                                        <h5 style="margin-top: 0.6rem;margin-left: 0.4rem;margin-bottom: 1rem">{{$data['menus'][$i+$j]->Подчинённый}}</h5>
                                                        <div class="row" style="margin-bottom: 0.6rem">
                                                            <div class="col-md-1"></div>
                                                            <a class="btn btn-primary col-md-4" href="{{route('EditMenu',$data['menus'][$i+$j]->ID)}}">
                                                                Редактировать
                                                            </a>
                                                            <div class="col-md-2"></div>
                                                            <a class="btn btn-primary col-md-4" href="{{route('DeleteMenu',$data['menus'][$i+$j]->ID)}}">
                                                                Удалить
                                                            </a>
                                                            <div class="col-md-1"></div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif
                                            @if($data['menus'][$i+$j]->Тип!='LINKS_LIST'&&$data['menus'][$i+$j]->Тип!='FEED_LIST')
                                                <div style="color: #1b1e21; border: 1px solid #d7dfe3; margin-bottom: 2rem">
                                                    <img style="width: 100%; height: 70%" src="/images/fon{{rand(1,5)}}.jpg" alt="">
                                                    <h5 style="margin-top: 0.6rem;margin-left: 0.4rem;margin-bottom: 1rem">{{$data['menus'][$i+$j]->Подчинённый}}</h5>
                                                    <div class="row" style="margin-bottom: 0.6rem">
                                                        <div class="col-md-1"></div>
                                                        <a class="btn btn-primary col-md-4" href="{{route('EditMenu',$data['menus'][$i+$j]->ID)}}">
                                                            Редактировать
                                                        </a>
                                                        <div class="col-md-2"></div>
                                                        <a class="btn btn-primary col-md-4" href="{{route('DeleteMenu',$data['menus'][$i+$j]->ID)}}">
                                                            Удалить
                                                        </a>
                                                        <div class="col-md-1"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endisset
                                @endfor
                                @if($i>=(Count($data['menus'])-2))
                                    <div class="col-md-4">
                                        <a href="{{route('CreateSubMenu',$data['IDUpper'])}}" style="color: #227dc7; text-decoration: none">
                                            <div class="row" style="margin-top: 2rem">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-4">
                                                    <img src="/images/sinijplus.svg" width="70%" height="70%">
                                                </div>
                                                <div class="col-md-4"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-8">
                                                    <h4>Добавить пункт меню</h4>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>
                                        </a>
                                    </div>
                                 @endif
                            </div>
                        @endfor
                        @if(Count($data['menus'])==0)
                            <div class="row" style="background-color: white; height: 20rem">
                                <div class="col-md-4">
                                    <a href="{{route('CreateSubMenu',$data['IDUpper'])}}" style="color: #227dc7; text-decoration: none">
                                        <div class="row" style="margin-top: 2rem">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4">
                                                <img src="/images/sinijplus.svg" width="70%" height="70%">
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <h4>Добавить пункт меню</h4>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endisset
                @isset($data['ПунктМеню'])
                    <div class="row">
                        <a class="btn btn-primary" href="{{route('CreatePage',$data['ПунктМеню'])}}">
                            Добавить страницу
                        </a>
                    </div>
                @endisset
            </main>
        </div>
    </div>
@endsection
