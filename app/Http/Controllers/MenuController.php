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
        $titles = ['ID','Подчинённый','УровеньМеню','ЯзыкПодчинённого','Тип','Ссылка','ПорядокОтображения','IDСтатьи','IDРодителя','Родитель'];
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
        $titles = ['ID','Подчинённый','УровеньМеню','ЯзыкПодчинённого','Тип','Ссылка','ПорядокОтображения','IDСтатьи','IDРодителя','Родитель'];
        for($i=0;$i<Count($menu);$i++){
            $data['menu'][$i] = [];
            $j = 0;
            foreach ($menu[$i] as $element){
                $data['menu'][$i][$titles[$j]] = $element;
                $j++;
            }
        }
        $listpages = DB::select('Select DISTINCT Страница, [Пункт меню] From ArticlesInfo Where [Пункт меню]=?', [$name1]);
        $titles = ['Страница','ПунктМеню'];
        for($i=0;$i<Count($listpages);$i++){
            $data['listpages'][$i] = [];
            $j = 0;
            foreach ($listpages[$i] as $element){
                $data['listpages'][$i][$titles[$j]] = $element;
                $j++;
            }
        }
        $titles = ['Страница','ПунктМеню','Язык','IDСтатьи','НазваниеСтатьи','ТекстСтатьи','ВремяСозданияСтатьи','КраткаяВерсия'];
        $listnews = DB::select('Select * From ArticlesInfo Where [Пункт меню]=?', [$name1]);
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
    public function CreateNews($PageName){
        $Page = DB::select('SELECT DISTINCT Страница, [Пункт меню], Язык FROM ArticlesInfo WHERE Страница=?',[$PageName]);
        $titles = ['Страница','ПунктМеню','Язык'];
        $j=0;
        $data = [];
        for($i=0;$i<Count($Page);$i++){
            $j = 0;
            foreach ($Page[$i] as $element){
                $data[$titles[$j]] = $element;
                $j++;
            }
        }
        $Page = $data;
        return view('CreateNews',['Page'=>$Page]);
    }
    public function SaveNews(Request $request){
        DB::statement('EXECUTE AddArticle ?,?,?,?,?',[$request->input('name'),$request->input('text'),
            $request->input('topic'),$request->input('language'),$request->input('description')]);
        DB::statement('EXECUTE AddArticlesInPages ?, ?',[$request->input('page'),$request->input('name')]);
        return redirect()->route('GetNews',$request->input('menupunct'));
    }
    public function SaveImage(Request $request){
        $file = $request->file;
        $filename = $file->getClientOriginalName();
        $file->storeAs('images', $filename);
        $path = storage_path() . "\app\images\\" . $filename;
        $imagedata = unpack("H*hex",file_get_contents($path));
        $imagedata = '0x'.$imagedata['hex'];
        //dd($imagedata[1]);
        $filecontent = base64_encode($file->openFile()->fread($file->getSize()));
        //dd($filecontent);
        $filename = $file->getClientOriginalName();
        DB::statement('INSERT INTO Медиа(Данные) VALUES(CONVERT(VARBINARY(MAX),?));',[$imagedata]);
        $url = 'http://109.123.155.178:8080/media/img/';
        $id = DB::select('SELECT [Id Медиа] FROM [Медиа] ORDER BY [Время создания] DESC');
        foreach ($id[0] as $elem){
            $id = $elem;
        }
        $url = $url . $id;
        return $url;
    }
}
