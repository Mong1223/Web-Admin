
@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        @for($i=0;$i<Count($data['menu']);$i++)
                            @if($data['menu'][$i]->position1==1)
                                <li class="nav-item" onclick="submenushow({{$i}})" style="cursor: pointer">{{$data['menu'][$i]->name1}}</li>
                            <div id="lvl2{{$i}}" class="lvl2">
                                @foreach($data['menu'] as $elem2)
                                    @if($elem2->name2==$data['menu'][$i]->name1)
                                        <li class="nav-item" style="cursor: pointer">
                                            <a href="{{route('GetNews', $elem2->name1)}}" style="text-decoration: none; color: #5a6268">
                                                {{$elem2->name1}}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
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
                            @if($menu->name1==$news->menuName)
                                <div class="news">
                                    <h2>{{$news->nwName}}</h2>
                                    <p>{{$news->nwTopic}}</p>
                                    <p>{{$news->nwTime}}</p>
                                    <p>{{$news->nwText}}</p>
                                    <p>{{$news->language}}</p>
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
