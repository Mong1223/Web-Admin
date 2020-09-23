<script src="{{ asset('js/app.js') }}" defer></script>
<div id="header" class="navbar navbar-light sticky-top bg-light header-bar">
    <div class="row">
        @isset($data['header'])
            <div class="header-block">
                <div id="hamburg" style="margin-left: auto; margin-right: auto; width: 2rem; margin-top: 1rem">
                    <svg id="ham" class="ham hamRotate ham1" viewBox="0 0 100 100" width="2rem">
                        <path
                            class="line top"
                            d="m 30,33 h 40 c 0,0 9.044436,-0.654587 9.044436,-8.508902 0,-7.854315 -8.024349,-11.958003 -14.89975,-10.85914 -6.875401,1.098863 -13.637059,4.171617 -13.637059,16.368042 v 40" />
                        <path
                            class="line middle"
                            d="m 30,50 h 40" />
                        <path
                            class="line bottom"
                            d="m 30,67 h 40 c 12.796276,0 15.357889,-11.717785 15.357889,-26.851538 0,-15.133752 -4.786586,-27.274118 -16.667516,-27.274118 -11.88093,0 -18.499247,6.994427 -18.435284,17.125656 l 0.252538,40" />
                    </svg>
                </div>
            </div>
        @else
            <div class="header-block" style="background-color: white; width: 2rem">
            </div>
        @endif
        <div class="header-header">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/" style="float: left">
                <img src="\images\0100_ccot_01.png" alt="" style="height: 70px; width: 310px">
            </a>
        </div>
    </div>
    <ul class="navbar-navbar-nav nav-flex-icons" style="margin-right: 3rem; float: left; list-style: none; text-decoration: none; color: #5a6268">
        <li class="nav-item dropdown" style="text-decoration: none; color: #5a6268; margin-right: 1rem; float: right">
            <a style="text-decoration: none; color: #5a6268" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->Имя }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('userSet') }}">
                    Группы
                </a>
                <a class="dropdown-item" href="{{ route('users') }}">
                    Отправка документов
                </a>

               <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Выход') }}
                </a>


                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
        <li id="messagesend" class="nav-item" style="list-style: none; float: right; margin-top: 0.4rem; margin-left: 1rem; cursor: pointer">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
            </svg>
        </li>
        <li id="langs" class="nav-item" style="list-style: none; float: right; margin-top: 0.4rem">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-globe" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M1.018 7.5h2.49c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5zM2.255 4H4.09a9.266 9.266 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.024 7.024 0 0 0 2.255 4zM8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm-.5 1.077c-.67.204-1.335.82-1.887 1.855-.173.324-.33.682-.468 1.068H7.5V1.077zM7.5 5H4.847a12.5 12.5 0 0 0-.338 2.5H7.5V5zm1 2.5V5h2.653c.187.765.306 1.608.338 2.5H8.5zm-1 1H4.51a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm1 2.5V8.5h2.99a12.495 12.495 0 0 1-.337 2.5H8.5zm-1 1H5.145c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12zm-2.173 2.472a6.695 6.695 0 0 1-.597-.933A9.267 9.267 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM1.674 11H3.82a13.651 13.651 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm8.999 3.472A7.024 7.024 0 0 0 13.745 12h-1.834a9.278 9.278 0 0 1-.641 1.539 6.688 6.688 0 0 1-.597.933zM10.855 12H8.5v2.923c.67-.204 1.335-.82 1.887-1.855A7.98 7.98 0 0 0 10.855 12zm1.325-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm.312-3.5h2.49a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.91 4a9.277 9.277 0 0 0-.64-1.539 6.692 6.692 0 0 0-.597-.933A7.024 7.024 0 0 1 13.745 4h-1.834zm-1.055 0H8.5V1.077c.67.204 1.335.82 1.887 1.855.173.324.33.682.468 1.068z"/>
            </svg>
            @isset($data['menulangs'])
                <div id="langs-panel" class="d-none" style="position: absolute; top: 1.2rem; right: 11rem;">
                    <table class="table table-bordered table-secondary" style="z-index: 10">
                        @for($i=0;$i<Count($data['menulangs']);$i++)
                            <tr>
                                <td>
                                    <a href="{{route('GetMenuByLang',$data['menulangs'][$i]->Наименование)}}" style="color: black; text-decoration: none">
                                    {{$data['menulangs'][$i]->Наименование}}
                                    </a>
                                </td>
                            </tr>
                        @endfor
                    </table>
                </div>
            @endisset
        </li>
    </ul>
</div>
