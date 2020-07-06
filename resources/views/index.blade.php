@extends('layouts.master')
@section('content')
    <?php
        function menufunc($data){
            if($data['Тип']=='LINS_LIST'){
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
                                    @foreach($data['menu'] as $elem2)
                                        @if($elem2['Родитель']==$data['menu'][$i]['Подчинённый'])
                                            <li class="nav-item" style="cursor: pointer">
                                                @if($elem2['Тип']=='FEED_LIST')
                                                    <a href="{{route('GetNews', $elem2['Подчинённый'])}}" style="text-decoration: none; color: #5a6268">
                                                        {{$elem2['Подчинённый']}}
                                                    </a>
                                                @endif
                                                {{$elem2['Подчинённый']}}
                                            </li>
                                        @endif
                                    @endforeach
                                    <button>
                                        Добавить пункт меню
                                    </button>
                                </div>
                            @endif
                        @endfor
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div class="news-content">
                @isset($data['listnews'])
                    @foreach($data['menu'] as $menu)
                        @foreach($data['listnews'] as $news)
                            @if($menu['Подчинённый']==$news['ПунктМеню'])
                                <div class="news">
                                    <h2>{{$news['НазваниеСтатьи']}}</h2>
                                    <p>{{$news['ВремяСозданияСтатьи']}}</p>
                                    <p>{{$news['ТекстСтатьи']}}</p>
                                    <p>{{$news['Язык']}}</p>
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
