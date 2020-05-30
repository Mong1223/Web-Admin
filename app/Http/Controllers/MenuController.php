<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menun;
use DB;
class MenuController extends Controller
{
    public function GetMenu(){

        $menu = DB::select('SELECT * FROM menulv1');
        $data['menu'] = $menu;
        return view ('index',['data'=>$data]);
    }
    public function GetNews($name1){
        $menu = DB::select('SELECT * FROM menulv1');
        $listnews = DB::select('Select * From ListNews Where menuName=?', [$name1]);
        $data['menu'] = $menu;
        $data['listnews'] = $listnews;
        return view ('index',['data'=>$data]);
    }
}
