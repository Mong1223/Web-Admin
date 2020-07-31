<script src="{{ asset('js/app.js') }}" defer></script>
<div class="navbar navbar-light sticky-top bg-light header-bar">
    <div class="row">
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
        <div class="header-header">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/">
                <img src="\images\0100_ccot_01.png" alt="" style="height: 70px; width: 310px">
            </a>
            <ul class="navbar-nav px-3">
                    <!--<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                           <form action="{{route('logout')}}" method="post">
                               @csrf
                               <button type="submit">Logout</button>
                            </form>
                        </div>
                    </div>-->
            </ul>
        </div>
    </div>
</div>
