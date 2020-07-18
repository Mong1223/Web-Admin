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
        $menu = DB::select('SELECT * FROM Menu ORDER BY [Уровень меню], [Порядок отображения]');
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
        /*$tempdata = [];//Хотел иерархию построить, будет время подумаю над этим
        $i = 0;
        foreach ($data['menu'] as $element){
            $tempdata[(int)$element['УровеньМеню']][$i] = $element;
            $i++;
        }
        for($i=3;$i>1;$i--){
            foreach ($tempdata[$i] as $el){
                foreach ($tempdata[$i-1] as $elem){
                    if($elem['Подчинённый']==$el['Родитель'])
                        $elem['Подчинённый']['Подчинённые'] = $el;
                }
            }
        }
        dd($tempdata);*/
        return view ('index',['data'=>$data]);
    }
    public function CreateUpMenu(){
        $menu = DB::select('SELECT TOP(1) [Порядок отображения] FROM Menu WHERE [Уровень меню] = ? ORDER BY [Порядок отображения] DESC', [1]);
        $data['ПорядокОтображения'] = 0;
        for($i=0;$i<Count($menu);$i++){
            $j = 0;
            foreach ($menu[$i] as $element){
                $data['ПорядокОтображения'] = $element;
                $j++;
            }
        }
        $data['ПорядокОтображения'] = (int) $data['ПорядокОтображения'] + 1;
        $langs = DB::select('SELECT * FROM Языки');
        $titles = ['ID','Наименование'];
        for($i=0;$i<Count($langs);$i++){
            $data['langs'][$i] = [];
            $j = 0;
            foreach ($langs[$i] as $element){
                $data['langs'][$i][$titles[$j]] = $element;
                $j++;
            }
        }
        $data['level']=1;
        //dd($data);
        return view('CreateMenu',['data'=>$data]);
    }
    public function SaveMenu(Request $request){
        $upper = $request->input('nameUpperMenu');
        $text = '<!DOCTYPE HTML><html><head><meta charset=\"utf-8\"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="viewport" content="width=device-width, initial-scale=1.0">'.'<title>'
        .$request->input('name').'</title>'.'</head>'.'<body>'.$request->input('text').'</body>'.'</html>';
        if($request->input('type')=='LINK'){
            DB::statement('EXECUTE AddMenuItem ?,?,?,?,?,?,?',[$request->input('level'),$request->input('name'),
                $upper,$request->input('Language'),$request->input('order'),
                $request->input('type'),$request->input('link')]);
        }
        if($request->input('type')=='ARTICLE'){
            DB::statement('EXECUTE AddMenuItem ?,?,?,?,?,?,?',[$request->input('level'),$request->input('name'),
                $upper,$request->input('Language'),$request->input('order'),
                $request->input('type'),null]);
            DB::statement('EXECUTE AddArticle ?,?,?,?,?',[$request->input('namearticle'),
                $text,$request->input('topicarticle'),$request->input('Language'),
                $request->input('description')]);
            DB::statement('DECLARE @IdArticle UNIQUEIDENTIFIER
                                 DECLARE @IdMenu UNIQUEIDENTIFIER
                                 SELECT @IdArticle = Статья.[Id статьи]
                                 FROM Статья
                                 WHERE Статья.Название=?
                                 SELECT @IdMenu = [Представление меню].[Id пункта меню]
                                 FROM [Представление меню]
                                 WHERE [Представление меню].[Наименование]=?
                                 INSERT INTO [Статьи пункты меню]([ID Пункта меню], [ID статьи]) VALUES(@IdMenu,@IdArticle)',
                [$request->input('namearticle'),$request->input('name')]);
        }
        if($request->input('type')!='LINK'&&$request->input('type')!='ARTICLE'){
            DB::statement('EXECUTE AddMenuItem ?,?,?,?,?,?,?',[$request->input('level'),$request->input('name'),
                $upper,$request->input('Language'),$request->input('order'),
                $request->input('type'),null]);
        }
        return redirect()->route('index');
    }
    public function DeleteMenu($Id){
        DB::statement('EXECUTE DeleteMenuItem ?',[$Id]);
        return redirect()->route('index');
    }
    public function CreateSubMenu($Id){
        $menu = DB::select('SELECT * FROM Menu WHERE [ID] = ? ORDER BY [Уровень меню], [Порядок отображения]',[$Id]);
        $data['uppermenu'] = [];
        $titles = ['ID','Подчинённый','УровеньМеню','ЯзыкПодчинённого','Тип','Ссылка','ПорядокОтображения','IDСтатьи','IDРодителя','Родитель'];
        for($i=0;$i<Count($menu);$i++){
            $j = 0;
            foreach ($menu[$i] as $element){
                $data['uppermenu'][$titles[$j]] = $element;
                $j++;
            }
        }
        $order = DB::select('SELECT TOP(1) [Порядок отображения] FROM Menu
                                   WHERE [Уровень меню] = ? AND [ID родителя] = ?
                                   ORDER BY [Порядок отображения] DESC',
                                   [(int)$data['uppermenu']['УровеньМеню']+1,$data['uppermenu']['ID']]);
        $data['ПорядокОтображения'] = 0;
        for($i=0;$i<Count($order);$i++){
            $j = 0;
            foreach ($order[$i] as $element){
                $data['ПорядокОтображения'] = $element;
                $j++;
            }
        }
        $data['ПорядокОтображения'] = (int) $data['ПорядокОтображения'] + 1;
        $langs = DB::select('SELECT * FROM Языки');
        $titles = ['ID','Наименование'];
        for($i=0;$i<Count($langs);$i++){
            $data['langs'][$i] = [];
            $j = 0;
            foreach ($langs[$i] as $element){
                $data['langs'][$i][$titles[$j]] = $element;
                $j++;
            }
        }
        $data['level']=(int)$data['uppermenu']['УровеньМеню']+1;
        //dd($data);
        return view('CreateMenu',['data'=>$data]);
    }
}
