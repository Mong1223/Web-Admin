@extends('layouts.master')
@section('content')
    <?php
        function menufunc($data, $i,$alldata){
            if($data['УровеньМеню']==1){
                echo '<li class="nav-item" onclick="submenushow({{$i}})" style="cursor: pointer">';
                if($data['Тип']=='LINKS_LIST'){
                    echo '<li class="nav-item" onclick="submenushow({{',$i,'}})" style="cursor: pointer">';
                    if($data['Тип']=='FEED_LIST'){
                        echo '<a href="{{',route('GetNews', $data['Подчинённый']),'}}" style="text-decoration: none; color: #5a6268">';
                        echo $data['Подчинённый'];
                        echo '</a>';
                    }
                    else{
                        echo $data['Подчинённый'];
                    }
                    echo '</li>';
                    foreach($alldata as $alldatum){

                    }
                }
                echo '</div>';
            }
            if($data['УровеньМеню']!=1){
                echo '<div id="lvl2{{',$i,'}}" class="lvl2">';
                if($data['Тип']=='LINKS_LIST'){
                    echo '<li class="nav-item" onclick="submenushow({{',$i,'}})" style="cursor: pointer">';
                    if($data['Тип']=='FEED_LIST'){
                        echo '<a href="{{',route('GetNews', $data['Подчинённый']),'}}" style="text-decoration: none; color: #5a6268">';
                        echo $data['Подчинённый'];
                        echo '</a>';
                    }
                    else{
                        echo $data['Подчинённый'];
                    }
                    echo '</li>';
                    foreach($alldata as $alldatum){

                    }
                }
                echo '</div>';
            }
        }
    ?>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        @for($i=0;$i<Count($data['menu']);$i++)
                            @if($data['menu'][$i]['УровеньМеню']==1)
                                <li class="nav-item" onclick="submenushow({{$i}})" style="cursor: pointer">
                                    @if($data['menu'][$i]['Тип']=='FEED_LIST')
                                        <a href="{{route('GetNews', $data['menu'][$i]['Подчинённый'])}}" style="text-decoration: none; color: #5a6268">
                                            {{$data['menu'][$i]['Подчинённый']}}
                                        </a>
                                    @else
                                        {{$data['menu'][$i]['Подчинённый']}}
                                    @endif
                                </li>
                                <div id="lvl2{{$i}}" class="lvl2">
                                    @for($j=0;$j<Count($data['menu']);$j++)
                                        @if($data['menu'][$j]['Родитель']==$data['menu'][$i]['Подчинённый'])
                                            <li class="nav-item" style="cursor: pointer" onclick="submenushow({{$j}})">
                                                @if($data['menu'][$j]['Тип']=='FEED_LIST')
                                                    <a href="{{route('GetNews', $data['menu'][$j]['Подчинённый'])}}" style="text-decoration: none; color: #5a6268">
                                                        {{$data['menu'][$j]['Подчинённый']}}
                                                    </a>
                                                @endif
                                                {{$data['menu'][$j]['Подчинённый']}}
                                            </li>
                                            <div id="lvl2{{$j}}" class="lvl2">
                                                @foreach($data['menu'] as $elem3)
                                                    @if($elem3['Родитель']==$data['menu'][$j]['Подчинённый'])
                                                        <li class="nav-item" style="cursor: pointer">
                                                            @if($elem3['Тип']=='FEED_LIST')
                                                                <a href="{{route('GetNews', $elem3['Подчинённый'])}}" style="text-decoration: none; color: #5a6268">
                                                                    {{$elem3['Подчинённый']}}
                                                                </a>
                                                            @endif
                                                            {{$elem3['Подчинённый']}}
                                                        </li>
                                                    @endif
                                                @endforeach
                                                @if($data['menu'][$j]['Тип']=='LINKS_LIST')
                                                    <button class="btn btn-dark">
                                                        Добавить пункт меню
                                                    </button>
                                                @endif
                                            </div>
                                        @endif
                                    @endfor
                                    @if($data['menu'][$i]['Тип']=='LINKS_LIST')
                                        <button class="btn btn-dark">
                                            Добавить пункт меню
                                        </button>
                                    @endif
                                </div>
                            @endif
                        @endfor
                            <button class="btn btn-dark" style="margin-top: 1rem">
                                Добавить пункт меню
                            </button>
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div class="news-content">
                @isset($data['listnews'])
                    @foreach($data['menu'] as $menu)
                        @foreach($data['listpages'] as $pages)
                            @if($menu['Подчинённый']==$pages['ПунктМеню'])
                                <div class="row">
                                    <div class="col-md-8" style="background: white; border: 1px solid black; border-radius: 4px">
                                        <h2 style="padding-top: 1rem; padding-left: 0.6rem">{{$pages['Страница']}}</h2>
                                        <div class="row">
                                            @foreach($data['listnews'] as $news)
                                                @if($pages['Страница']==$news['Страница'])
                                                    <div class="col-md-8">
                                                        <h4 style="padding-left: 0.6rem">{{$news['НазваниеСтатьи']}}</h4>
                                                        <p style="padding-left: 0.6rem">{{$news['ВремяСозданияСтатьи']}}</p>
                                                        <p style="padding-left: 0.6rem">{{$news['Язык']}}</p>
                                                        <p style="padding-left: 0.6rem">{{$news['КраткаяВерсия']}}</p>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-dark" style="margin-top: 1rem">
                                                            Редактировать
                                                        </button>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-dark" style="margin-top: 1rem">
                                                            Удалить
                                                        </button>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <form method="GET" action="{{route('CreateNews',$pages['Страница'])}}">
                                                <button class="btn btn-dark" style="margin-left: 1rem; margin-bottom: 1rem">
                                                    Добавить статью
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-2 align-content-md-center">
                                        <button class="btn btn-dark" style="margin-top: 1rem">
                                            Редактировать
                                        </button>
                                    </div>
                                    <div class="col-md-2 justify-content-center">
                                        <button class="btn btn-dark align-content-center" style="margin-top: 1rem">
                                            Удалить
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                @endisset
                </div>
            </main>

        </div>
    </div>
@endsection
