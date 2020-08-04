@extends('layouts.master')
@section('content')
    <div class="container-fluid" style="margin-bottom: 1rem">
        <div class="row" style="margin-bottom: 2rem">
            <nav id="content-nav" class="col-md-1 d-md-block sidebar sidebar-little">
                <div class="sidebar-sticky d-none" style="margin-top: 1rem" id="sidebar-content">
                    <ul class="nav flex-column">
                        @for($i=0;$i<Count($data['menu']);$i++)
                            <li class="row row-nav" style="height: auto">
                                <div class="nav-item col-md-8" onclick="submenushow({{$i}})" style="cursor: pointer">
                                    @if($data['menu'][$i]['Тип']=='FEED_LIST')
                                        <a href="{{route('GetNews', $data['menu'][$i]['Подчинённый'])}}" style="text-decoration: none;">
                                            {{$data['menu'][$i]['Подчинённый']}}
                                        </a>
                                    @else
                                        @if($data['menu'][$i]['Тип']=='LINKS_LIST')
                                            <a href="{{route('GetSubMenu',$data['menu'][$i]['ID'])}}" style="text-decoration: none">
                                                {{$data['menu'][$i]['Подчинённый']}}
                                            </a>
                                        @else
                                            {{$data['menu'][$i]['Подчинённый']}}
                                        @endif
                                    @endif
                                </div>
                                <a class="col-md-2 close" style="color: white" href="{{route('DeleteMenu',$data['menu'][$i]['ID'])}}" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </a>
                                <a class="col-md-2" style="margin-top: 0.2rem" href="{{route('EditMenu',$data['menu'][$i]['Подчинённый'])}}">
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
                <div class="news-content">
                    @isset($data['listpages'])
                        @foreach($data['listpages'] as $pages)
                            <div class="row">
                                <div class="col-md-12 content">
                                    <div class="row page-header">
                                        <div class="col-md-10">
                                            <h2 style="padding-top: 1rem; padding-left: 0.6rem">{{$pages['Страница']}}</h2>
                                        </div>
                                        <div class="col-md-1">
                                            <a href="" class="align-content-center">
                                                <svg style="margin-top: 1.4rem" width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-gear-wide" fill="black" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c-.719.695-.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434L8.932.727zM8 12.997a4.998 4.998 0 1 0 0-9.995 4.998 4.998 0 0 0 0 9.996z"/>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="col-md-1">
                                            <a href="{{route('DeletePage',$pages['Страница'])}}" class="align-content-center">
                                                <svg style="margin-top: 1.4rem" width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-trash" fill="black" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    @isset($data['listnews'])
                                        @foreach($data['listnews'] as $news)
                                            @if($pages['Страница']==$news['Страница'])
                                                <div class="row article-content">
                                                    <div class="col-md-10">
                                                        <h5 class="article-title" style="padding-left: 0.6rem; cursor: pointer">
                                                            {{$news['НазваниеСтатьи']}}
                                                        </h5><div class="d-none">
                                                            <p style="padding-left: 0.6rem">{{$news['ВремяСозданияСтатьи']}}</p>
                                                            <p style="padding-left: 0.6rem">{{$news['Язык']}}</p>
                                                            <p style="padding-left: 0.6rem">{{$news['КраткаяВерсия']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a href="{{route('EditNews',$news['IDСтатьи'])}}" class="align-content-center">
                                                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-gear-wide" fill="black" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c-.719.695-.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434L8.932.727zM8 12.997a4.998 4.998 0 1 0 0-9.995 4.998 4.998 0 0 0 0 9.996z"/>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a href="{{route('DeleteNews',$news['IDСтатьи'])}}" class="align-content-center">
                                                            <svg  width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-trash" fill="black" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endisset
                                    <form method="GET" action="{{route('CreateNews',[$pages['ПунктМеню'],$pages['Страница']])}}">
                                        <button class="btn btn-primary button">
                                            Добавить статью
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                </div>
                <div>
                    @isset($data['news'])
                        @foreach($data['news'] as $news)
                            <div class="row">
                                <div class="col-md-8" style="background: white; border: 1px solid black; border-radius: 4px; margin-bottom: 1rem">
                                    <div class="row" style="padding-top: 1rem">
                                        <div class="col-md-8">
                                            <h4 style="padding-left: 0.6rem">{{$news['Статья']}}</h4>
                                            <p style="padding-left: 0.6rem">{{$news['ВремяСозданияСтатьи']}}</p>
                                            <p style="padding-left: 0.6rem">{{$news['Тематика']}}</p>
                                            <p style="padding-left: 0.6rem">{{$news['КраткаяВерсия']}}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="btn btn-light" style="margin-top: 1rem">
                                                Редактировать
                                            </a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{route('DeleteNews',$news['IDСтатьи'])}}" class="btn btn-light" style="margin-top: 1rem; margin-left: 1rem">
                                                Удалить
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                </div>
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
