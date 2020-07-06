<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Env;
use PHPUnit\Framework\Constraint\Count;

class MenuController extends Controller
{
    public function GetMenu(){
        $menu = DB::select('SELECT * FROM Menu');
        $data['menu'] = [];
        $titles = ['ID','Подчинённый','УровеньМеню','Тип','Ссылка','ПорядокОтображения','ЯзыкПодчинённого','IDРодителя','Родитель'];
        for($i=0;$i<Count($menu);$i++){
            $data['menu'][$i] = [];
            $j = 0;
            foreach ($menu[$i] as $element){
                $data['menu'][$i][$titles[$j]] = $element;
                $j++;
            }
        }
        //dd($data);
        return view ('index',['data'=>$data]);
    }
    public function GetNews($name1){
        $menu = DB::select('SELECT * FROM Menu');
        $data['menu'] = [];
        $titles = ['ID','Подчинённый','УровеньМеню','Тип','Ссылка','ПорядокОтображения','ЯзыкПодчинённого','IDРодителя','Родитель'];
        for($i=0;$i<Count($menu);$i++){
            $data['menu'][$i] = [];
            $j = 0;
            foreach ($menu[$i] as $element){
                $data['menu'][$i][$titles[$j]] = $element;
                $j++;
            }
        }
        $listnews = DB::select('Select * From ArticlesInfo Where [Пункт меню]=?', [$name1]);
        $titles = ['Страница','ПунктМеню','Язык','IDСтатьи','НазваниеСтатьи','ТекстСтатьи','ВремяСозданияСтатьи'];
        for($i=0;$i<Count($listnews);$i++){
            $data['listnews'][$i] = [];
            $j = 0;
            foreach ($listnews[$i] as $element){
                $data['listnews'][$i][$titles[$j]] = $element;
                $j++;
            }
        }
        return view ('index',['data'=>$data]);
    }
}
