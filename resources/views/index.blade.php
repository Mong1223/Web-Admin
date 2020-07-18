@extends('layouts.master')
@section('content')
    <div class="container-fluid" style="margin-bottom: 1rem">
        <div class="row">
            <nav class="col-md-3 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky" style="margin-top: 1rem">
                    <ul class="nav flex-column">
                        @for($i=0;$i<Count($data['menu']);$i++)
                            @if($data['menu'][$i]['УровеньМеню']==1)
                                <div class="row" style="height: 25px">
                                    <li class="nav-item col-md-8" onclick="submenushow({{$i}})" style="cursor: pointer">
                                        @if($data['menu'][$i]['Тип']=='FEED_LIST')
                                            <a href="{{route('GetNews', $data['menu'][$i]['Подчинённый'])}}" style="text-decoration: none; color: #5a6268">
                                                {{$data['menu'][$i]['Подчинённый']}}
                                            </a>
                                        @else
                                            {{$data['menu'][$i]['Подчинённый']}}
                                        @endif
                                    </li>
                                    <a class="col-md-2 close" href="{{route('DeleteMenu',$data['menu'][$i]['ID'])}}" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </a>
                                    <a class="col-md-2" style="margin-top: 0.2rem" href="">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                            <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                        </svg>
                                    </a>
                                </div>
                                <div id="lvl2{{$i}}" class="lvl2">
                                    @for($j=0;$j<Count($data['menu']);$j++)
                                        @if($data['menu'][$j]['Родитель']==$data['menu'][$i]['Подчинённый'])
                                            <div class="row" style="height: 25px; width: 20rem">
                                                <li class="nav-item col-md-8" style="cursor: pointer" onclick="submenushow({{$j}})">
                                                    @if($data['menu'][$j]['Тип']=='FEED_LIST')
                                                        <a href="{{route('GetNews', $data['menu'][$j]['Подчинённый'])}}" style="text-decoration: none; color: #5a6268">
                                                            {{$data['menu'][$j]['Подчинённый']}}
                                                        </a>
                                                    @else
                                                        {{$data['menu'][$j]['Подчинённый']}}
                                                    @endif
                                                </li>
                                                <a class="col-md-2 close" href="{{route('DeleteMenu',$data['menu'][$j]['ID'])}}" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </a>
                                                <a class="col-md-2" style="margin-top: 0.2rem" href="">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                                        <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                            <div id="lvl2{{$j}}" class="lvl2">
                                                @foreach($data['menu'] as $elem3)
                                                    @if($elem3['Родитель']==$data['menu'][$j]['Подчинённый'])
                                                        <div class="row" style="height: 25px">
                                                            <li class="nav-item col-md-8" style="cursor: pointer">
                                                                @if($elem3['Тип']=='FEED_LIST')
                                                                    <a class="getnews" href="{{route('GetNews', $elem3['Подчинённый'])}}" style="text-decoration: none; color: #5a6268">
                                                                        {{$elem3['Подчинённый']}}
                                                                    </a>
                                                                @else
                                                                    {{$elem3['Подчинённый']}}
                                                                @endif
                                                            </li>
                                                            <a class="col-md-2 close" href="{{route('DeleteMenu',$elem3['ID'])}}" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </a>
                                                            <a class="col-md-2" style="margin-top: 0.2rem" href="">
                                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                                                    <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                @if($data['menu'][$j]['Тип']=='LINKS_LIST')
                                                    <a href="{{route('CreateSubMenu',$data['menu'][$j]['ID'])}}" class="btn btn-dark" style="margin-bottom: 0.2rem">
                                                        Добавить пункт меню
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    @endfor
                                    @if($data['menu'][$i]['Тип']=='LINKS_LIST')
                                        <a href="{{route('CreateSubMenu',$data['menu'][$i]['ID'])}}" class="btn btn-dark" style="margin-bottom: 0.2rem">
                                            Добавить пункт меню
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @endfor
                            <a href="{{route('CreateUpMenu')}}" class="btn btn-dark" style="margin-bottom: 0.2rem">
                                Добавить пункт меню
                            </a>
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-9 pt-3 px-4">
                <div class="news-content">
                    @isset($data['listpages'])
                        @foreach($data['listpages'] as $pages)
                            <div class="row">
                                <div class="col-md-8" style="background: white; border: 1px solid black; border-radius: 4px; margin-bottom: 1rem">
                                    <h2 style="padding-top: 1rem; padding-left: 0.6rem">{{$pages['Страница']}}</h2>
                                    <div class="row">
                                        @isset($data['listnews'])
                                            @foreach($data['listnews'] as $news)
                                                @if($pages['Страница']==$news['Страница'])
                                                    <div class="col-md-8">
                                                        <h4 style="padding-left: 0.6rem">{{$news['НазваниеСтатьи']}}</h4>
                                                        <p style="padding-left: 0.6rem">{{$news['ВремяСозданияСтатьи']}}</p>
                                                        <p style="padding-left: 0.6rem">{{$news['Язык']}}</p>
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
                                                @endif
                                            @endforeach
                                        @endisset
                                    </div>
                                    <form method="GET" action="{{route('CreateNews',[$pages['ПунктМеню'],$pages['Страница']])}}">
                                        <button class="btn btn-dark" style="margin-left: 1rem; margin-bottom: 1rem">
                                            Добавить статью
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-2 align-content-md-center">
                                    <a href="" class="btn btn-dark" style="margin-top: 1rem">
                                        Редактировать
                                    </a>
                                </div>
                                <div class="col-md-2 justify-content-center">
                                    <a href="{{route('DeletePage',$pages['Страница'])}}" class="btn btn-dark align-content-center" style="margin-top: 1rem">
                                        Удалить
                                    </a>
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
                        <div class="col-md-2">
                            <a class="btn btn-light" href="{{route('CreatePage',$data['ПунктМеню'])}}">
                                Добавить страницу
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-light" href="{{route('CreateNews',[$data['ПунктМеню']," "])}}">
                                Добавить статью
                            </a>
                        </div>
                    </div>
                @endisset
            </main>
        </div>
    </div>
@endsection
