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
        $menu = DB::select("SELECT ID,Подчинённый, [Уровень меню] 'УровеньМеню',
                                  [Язык подчинённого] 'ЯзыкПодчинённого',Тип, Ссылка, [Порядок отображения] 'ПорядокОтображения',
                                  [ID статьи] 'IDCтатьи', [ID картинки] 'IDКартинки',[ID родителя] 'IDРодителя', Родитель
                                  FROM Menu WHERE [Уровень меню]=1 AND [Язык подчинённого]= 'rus' ORDER BY [Уровень меню], [Порядок отображения]");
        $data['menu'] = $menu;
        $langs = DB::select('SELECT [ID Языка] "IDЯзыка", Наименование FROM Языки');
        $data['menulangs'] = $langs;
        return view ('index',['data'=>$data]);
    }
    public function GetMenuByLang($name)
    {
        $menu = DB::select('SELECT ID, Подчинённый, [Уровень меню] "УровеньМеню", [Язык подчинённого] "ЯзыкПодчинённого",
                                  Тип, Ссылка, [Порядок отображения] "ПорядокОтображения", [ID статьи] "IDСтатьи",
                                  [ID картинки] "IDКартинки", [ID родителя] "IDРодителя", Родитель
                                  FROM Menu WHERE [Уровень меню]=1 AND [Язык подчинённого] = ?',[$name]);
        $data['menu'] = $menu;
        $langs = DB::select('SELECT [ID Языка] "IDЯзыка", Наименование FROM Языки');
        $data['menulangs'] = $langs;
        return view ('index',['data'=>$data]);
    }
    public function GetSubMenu($id,$lang)
    {
        $menu = DB::select('SELECT ID, Подчинённый, [Уровень меню] "УровеньМеню", [Язык подчинённого] "ЯзыкПодчинённого",
                                  Тип, Ссылка, [Порядок отображения] "ПорядокОтображения", [ID статьи] "IDСтатьи",
                                  [ID картинки] "IDКартинки", [ID родителя] "IDРодителя", Родитель
                                  FROM Menu WHERE [Уровень меню]=1 AND [Язык подчинённого] = ?',[$lang]);//Upper
        $data['menu'] = $menu;
        $menu = DB::select('SELECT ID,Подчинённый,[Уровень меню] "УровеньМеню",[Язык подчинённого] "ЯзыкПодчинённого",Тип,
                                  Ссылка, [Порядок отображения] "ПорядокОтображения",[ID статьи] "IDСтатьи",[ID родителя] "IDРодителя",
                                  Родитель FROM Menu WHERE [ID родителя]=? AND [Язык подчинённого]=?',[$id,$lang]);//Sub
        $data['menus'] = $menu;
        $data['IDUpper'] = $id;
        $langs = DB::select('SELECT [ID Языка] "IDЯзыка", Наименование FROM Языки');
        $data['menulangs'] = $langs;
        return view('index',['data'=>$data]);
    }
    public function CreateUpMenu(){
        $langs = DB::select('SELECT [Id языка] "ID", Наименование FROM Языки');
        $data['langs'] = $langs;
        $data['level']=1;
        return view('CreateMenu',['data'=>$data]);
    }
    public function SaveMenu(Request $request){
        dd($request);
        $langs = DB::select('SELECT [ID языка], Наименование FROM [Языки]');
        $upper = $request->input('nameUpperMenu');
        if($upper!=null){
            $idupper = DB::select('SELECT [ID] FROM Menu WHERE [Подчинённый]=?',[$upper])[0]->ID;
        }
        $date = getdate();
        $text = '<!DOCTYPE HTML><html><head><meta charset=\"utf-8\"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0">'.'<title>'.$request->input('name').'</title>'.'</head>'.'<body>'.
            '<time datetime="'.$date['year'].'-'.$date['mon'].'-'.$date['mday'].'" title="'.($date['hours']+7).':'.$date['minutes'].', '.$date['mday'].' '.$date['mon'].' '. $date['year'].'"></time>'. $request->input('text').'</body>'.'</html>';
        $order = DB::select('SELECT MAX([Порядок отображения]) "ПорядокОтображения"
                                   FROM Menu WHERE [Язык подчинённого]=? AND [Уровень меню] = ?',
            [$request->input("lang".$langs[0]->Наименование),$request->input('level')])[0]->ПорядокОтображения;
        if($request->input('type')=='LINK'){
            DB::statement('EXECUTE AddMenuItem ?,?,?,?,?,?,?',[$request->input('level'),$request->input("name".$langs[0]->Наименование),
                $upper,$request->input("lang".$langs[0]->Наименование),$order,
                $request->input('type'),$request->input('link')]);
            $menuid = DB::select('SELECT ID FROM Menu WHERE [Подчинённый] = ?', [$request->input("name".$langs[0]->Наименование)]);
            for($i=1;$i<Count($langs);$i++){
                DB::statement('INSERT INTO [Представление меню]([ID меню],[Наименование],[ID языка])
                                     VALUES (?,?,?)',[$menuid,$request->input("name".$langs[$i]->Наименование),$langs[$i]->ID]);
            }
        }
        if($request->input('type')=='ARTICLE'){
            DB::statement('EXECUTE AddMenuItem ?,?,?,?,?,?,?',[$request->input('level'),$request->input("name".$langs[0]->Наименование),
                $upper,$request->input("lang".$langs[0]->Наименование),$order,
                $request->input('type'),null]);
            DB::statement('EXECUTE AddArticle ?,?,?,?,?,?',[$request->input('namearticle'),
                $text,$request->input('topicarticle'),$request->input("lang".$langs[0]->Наименование),
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
            $menuid = DB::select('SELECT ID FROM Menu WHERE [Подчинённый] = ?', [$request->input("name".$langs[0]->Наименование)]);
            for($i=1;$i<Count($langs);$i++){
                DB::statement('INSERT INTO [Представление меню]([ID меню],[Наименование],[ID языка])
                                     VALUES (?,?,?)',[$menuid,$request->input("name".$langs[$i]->Наименование),$langs[$i]->ID]);
            }
        }
        if($request->input('type')!='LINK'&&$request->input('type')!='ARTICLE'){
            DB::statement('EXECUTE AddMenuItem ?,?,?,?,?,?,?',
                [$request->input('level'),$request->input("name".$langs[0]->Наименование),
                $upper,$request->input("lang".$langs[0]->Наименование),$order,
                $request->input('type'),null]);
            $menuid = DB::select('SELECT ID FROM Menu WHERE [Подчинённый] = ?', [$request->input("name".$langs[0]->Наименование)]);
            for($i=1;$i<Count($langs);$i++){
                DB::statement('INSERT INTO [Представление меню]([ID меню],[Наименование],[ID языка])
                                     VALUES (?,?,?)',[$menuid,$request->input("name".$langs[$i]->Наименование),$langs[$i]->ID]);
            }
        }
        return redirect()->route('GetSubMenu',$idupper);
    }
    public function DeleteMenu($Id){
        DB::statement('EXECUTE DeleteMenuItem ?',[$Id]);
        return redirect()->route('index');
    }
    public function CreateSubMenu($Id){
        $menu = DB::select('SELECT ID, Подчинённый, [Уровень меню] "УровеньМеню", [Язык подчинённого] "ЯзыкПодчинённого",
                                  Тип, Ссылка, [Порядок отображения] "ПорядокОтображения",
                                  [ID статьи] "IDСтатьи", [ID родителя] "IDРодителя", Родитель
                                  FROM Menu WHERE [ID] = ?
                                  ORDER BY [Уровень меню], [Порядок отображения]',[$Id]);
        $data['uppermenu'] = $menu;
        $langs = DB::select('SELECT ID,Наименование FROM Языки');
        $data['level']=(int)$data['uppermenu']['УровеньМеню']+1;
        //dd($data);
        return view('CreateMenu',['data'=>$data]);
    }
    public function EditMenu($name){
        $menu = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню',
                                  [Язык подчинённого] 'Язык', Тип, Ссылка,
                                  [Порядок отображения] 'ПорядокОтображения',[Id статьи] 'IdСтатьи',
                                  [Id родителя] 'IdРодителя',Родитель
                                  FROM Menu WHERE [ID]=?",[$name])[0];
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
