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
        $menu = DB::select("SELECT * FROM Menu WHERE [Уровень меню]=1 AND [Язык подчинённого]= 'Русский' ORDER BY [Уровень меню], [Порядок отображения]");
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
        $langs = DB::select('SELECT [ID Языка] "IDЯзыка", Наименование FROM Языки');
        $data['menulangs'] = $langs;
        return view ('index',['data'=>$data]);
    }
    public function GetMenuByLang($name)
    {
        $menu = DB::select('SELECT * FROM Menu WHERE [Уровень меню]=1 AND [Язык подчинённого] = ?',[$name]);
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
        $langs = DB::select('SELECT [ID Языка] "IDЯзыка", Наименование FROM Языки');
        $data['menulangs'] = $langs;
        return view ('index',['data'=>$data]);
    }
    public function GetSubMenu($id)
    {
        $lang = DB::select('SELECT [Язык подчинённого] "ЯзыкПодчинённого" FROM Menu WHERE ID = ?',[$id])[0];
        $menu = DB::select('SELECT * FROM Menu WHERE [Уровень меню]=1 AND [Язык подчинённого]=? ORDER BY [Уровень меню], [Порядок отображения]',[$lang->ЯзыкПодчинённого]);
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
        $menu = DB::select('SELECT ID,Подчинённый,[Уровень меню] "УровеньМеню",[Язык подчинённого] "ЯзыкПодчинённого",Тип,
                                  Ссылка, [Порядок отображения] "ПорядокОтображения",[ID статьи] "IDСтатьи",[ID родителя] "IDРодителя",
                                  Родитель FROM Menu WHERE [ID родителя]=?',[$id]);
        $data['menus'] = $menu;
        $data['IDUpper'] = $id;
        $langs = DB::select('SELECT [ID Языка] "IDЯзыка", Наименование FROM Языки');
        $data['menulangs'] = $langs;
        return view('index',['data'=>$data]);
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
        $idupper = DB::select('SELECT [ID] FROM Menu WHERE [Подчинённый]=?',[$upper])[0]->ID;
        $date = getdate();
        $text = '<!DOCTYPE HTML><html><head><meta charset=\"utf-8\"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0">'.'<title>'.$request->input('name').'</title>'.'</head>'.'<body>'.
            '<time datetime="'.$date['year'].'-'.$date['mon'].'-'.$date['mday'].'" title="'.($date['hours']+7).':'.$date['minutes'].', '.$date['mday'].' '.$date['mon'].' '. $date['year'].'"></time>'. $request->input('text').'</body>'.'</html>';
        if($request->input('type')=='LINK'){
            DB::statement('EXECUTE AddMenuItem ?,?,?,?,?,?,?',[$request->input('level'),$request->input('name'),
                $upper,$request->input('Language'),$request->input('order'),
                $request->input('type'),$request->input('link')]);
        }
        if($request->input('type')=='ARTICLE'){
            DB::statement('EXECUTE AddMenuItem ?,?,?,?,?,?,?',[$request->input('level'),$request->input('name'),
                $upper,$request->input('Language'),$request->input('order'),
                $request->input('type'),null]);
            DB::statement('EXECUTE AddArticle ?,?,?,?,?,?',[$request->input('namearticle'),
                $text,$request->input('topicarticle'),$request->input('Language'),
                $request->input('description'),$request->input('idimage')]);
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
        return redirect()->route('GetSubMenu',$idupper);
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
    public function EditMenu($name){
        $menu = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню',
                                  [Язык подчинённого] 'Язык', Тип, Ссылка,
                                  [Порядок отображения] 'ПорядокОтображения',[Id статьи] 'IdСтатьи',
                                  [Id родителя] 'IdРодителя',Родитель
                                  FROM Menu WHERE [Подчинённый]=?",[$name])[0];
        $data['menu']= $menu;
        if($data['menu']->Тип=='ARTICLE'){
            $article = DB::select("SELECT [Статья].[Id статьи] 'IdСтатьи', Название, Текст, Тематика,
                                         [Время создания] 'ВремяСоздания',[Краткая версия статьи] 'КраткаяВерсияСтатьи',
                                         [Картинка статьи] 'КартинкаСтатьи'
                                         FROM [Статья]
                                         WHERE [Id статьи]=?",[$data['menu']->IdСтатьи])[0];
            $data['article']=$article;
        }
        $langs = DB::select("SELECT [Id языка] 'IdЯзыка', Наименование
                                   FROM [Языки]");
        $data['langs'] = $langs;
        return view('EditMenu',['data'=>$data]);
    }
    public function UpdateMenu($Id,Request $request){
        $date = getdate();
        $text = '<!DOCTYPE HTML><html><head><meta charset=\"utf-8\"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0">'.'<title>'.$request->input('name').'</title>'.'</head>'.'<body>'.
            '<time datetime="'.$date['year'].'-'.$date['mon'].'-'.$date['mday'].'" title="'.($date['hours']+7).':'.$date['minutes'].', '.$date['mday'].' '.$date['month'].' '. $date['year'].'">'.$date['mday'].' '.$month[$date['mon']-1].' '.$date['year'].'</time>'. $request->input('text').'</body>'.'</html>';
        DB::statement('EXECUTE UpdateMenu ?,?,?,?,?,?,?,?,?,?,?,?',[$request->input('ID'),
            $request->input('name'),$request->input('Language'),$request->input('URL'),
            $request->input('order'),$request->input('type'),$request->input('IDArticle'),
            $request->input('namearticle'),$request->input('topicarticle'),$request->input('description'),
            $request->input('idimage'),$text]);
        return redirect()->route('index');
    }
}
