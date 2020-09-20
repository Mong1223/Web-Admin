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
                                  FROM Menu WHERE [Уровень меню]=1 AND [Язык подчинённого]= 'ru' ORDER BY [Уровень меню], [Порядок отображения]");
        $data['menu'] = $menu;
        $langs = DB::select('SELECT [ID Языка] "IDЯзыка", Наименование FROM Языки');
        $data['menulangs'] = $langs;
        $data['header']=true;
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
        $data['header']=true;
        return view ('index',['data'=>$data]);
    }
    public function GetSubMenu($id,$lang)
    {
        $menu = DB::select('SELECT ID, Подчинённый, [Уровень меню] "УровеньМеню", [Язык подчинённого] "ЯзыкПодчинённого",
                                  Тип, Ссылка, [Порядок отображения] "ПорядокОтображения", [ID статьи] "IDСтатьи",
                                  [ID картинки] "IDКартинки", [ID родителя] "IDРодителя", Родитель
                                  FROM Menu WHERE [Уровень меню]=1 AND [Язык подчинённого] = ?',[$lang]);//Upper
        $data['menu'] = $menu;
        $menu = DB::select('SELECT DISTINCT ID,Подчинённый,[Уровень меню] "УровеньМеню",[Язык подчинённого] "ЯзыкПодчинённого",Тип,
                                  Ссылка, [Порядок отображения] "ПорядокОтображения",[ID статьи] "IDСтатьи",[ID родителя] "IDРодителя"
                                  FROM Menu WHERE [ID родителя]=? AND [Язык подчинённого]=?',[$id,$lang]);//Sub
        $data['menus'] = $menu;
        $data['IDUpper'] = $id;
        $langs = DB::select('SELECT [ID Языка] "IDЯзыка", Наименование FROM Языки');
        $data['menulangs'] = $langs;
        $mens = [];
        $mens[0] = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню', [Язык подчинённого] 'ЯзыкПодчинённого', Тип
                                      FROM Menu WHERE ID=?",[$id])[0];
        $level = $mens[0]->УровеньМеню;
        $i = 1;
        while($level!=1)
        {
            $punkt = DB::select("SELECT [ID родителя] 'IDРодителя' FROM Menu WHERE ID=?",[$id])[0]->IDРодителя;
            $punkt = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню', [Язык подчинённого] 'ЯзыкПодчинённого',
                                       Тип FROM Menu WHERE ID=?",[$punkt])[0];
            $level = $punkt->УровеньМеню;
            $mens[$i] = $punkt;
            $id = $punkt->ID;
        }
        $mens = array_reverse($mens);
        $data['mens']=$mens;
        $data['header']=true;
        //dd($data);
        return view('index',['data'=>$data]);
    }
    public function CreateUpMenu(){
        $langs = DB::select('SELECT [Id языка] "ID", Наименование FROM Языки');
        $data['langs'] = $langs;
        $data['level'] = 1;
        //dd($data);
        return view('CreateMenu',['data'=>$data]);
    }
    public function SaveMenu(Request $request){
        //dd($request);
        $langs = DB::select('SELECT [ID языка] "ID", Наименование FROM [Языки]');
        $upper = $request->input('nameUpperMenu');
        if($upper!=null){
            $idupper = DB::select('SELECT [ID] FROM Menu WHERE [Подчинённый]=?',[$upper])[0]->ID;
        }
        $order = DB::select('SELECT COUNT(*) "Количество" FROM Menu
                             WHERE [Язык подчинённого]=? AND [Уровень меню]=?',
            [$request->input('Language'),$request->input('level')])[0]->Количество;
        if($request->input('type')=='LINK'){
            DB::statement('EXECUTE AddMenuItem ?,?,?,?,?,?,?',[$request->input('level'),$request->input("name"),
                $upper,$request->input("Language"),$order,
                $request->input('type'),$request->input('link'),$request->input('idimage')]);
        }
        if($request->input('type')=='ARTICLE'){
            $date = getdate();
            //$month = ['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октабря','ноября','декабря'];
            $text = '<!DOCTYPE HTML><html><head><meta charset=\"utf-8\"><meta name="viewport" content="width=device-width, initial-scale=1.0">
                     <meta name="viewport" content="width=device-width, initial-scale=1.0">'.
                     '<title>'.$request->input('name').'</title>'.'</head>'.'<body>'.
                     '<time datetime="'.$date['year'].'-'.$date['mon'].'-'.$date['mday'].'" title="'.($date['hours']+7).':'.$date['minutes'].
                     ', '.$date['mday'].' '.$date['month'].' '. $date['year'].'">'/*.$date['mday'].' '.$month[$date['mon']-1].' '.
                     $date['year']*/.'</time>'. $request->input('text').'</body>'.'</html>';
            DB::statement('EXECUTE AddMenuItem ?,?,?,?,?,?,?',[$request->input('level'),$request->input("name"),
                $upper,$request->input("Language"),$order,
                $request->input('type'),null,$request->input('idimage')]);
            DB::statement('EXECUTE AddArticle ?,?,?,?,?,?',[$request->input('namearticle'),
                $text,$request->input('topicarticle'),$request->input("Language"),
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
        }//Потом пригодится
        if($request->input('type')!='LINK'&&$request->input('type')!='ARTICLE'){
            DB::statement('EXECUTE AddMenuItem ?,?,?,?,?,?,?',
                [$request->input('level'),$request->input("name"),
                $upper,$request->input("Language"),$order,
                $request->input('type'),null,$request->input('idimage')]);
        }
        if($upper!=null)
            return redirect()->route('GetSubMenu',[$idupper,$request->input("Language")]);
        else
            return redirect()->route('GetMenuByLang',$request->input("Language"));
    }
    public function DeleteMenu($Id){
        $data = DB::select('SELECT [Язык подчинённого] "Язык", [ID родителя] "ID" FROM Menu WHERE ID = ?',[$Id])[0];
        DB::statement('EXECUTE DeleteMenuItem ?',[$Id]);
        if($data->ID!=null)
            return redirect()->route('GetSubMenu',[$data->ID,$data->Язык]);
        else
            return redirect()->route('GetMenuByLang',$data->Язык);
    }
    public function CreateSubMenu($Id){
        $menu = DB::select('SELECT ID, Подчинённый, [Уровень меню] "УровеньМеню", [Язык подчинённого] "ЯзыкПодчинённого",
                                  Тип, Ссылка, [Порядок отображения] "ПорядокОтображения",
                                  [ID статьи] "IDСтатьи", [ID родителя] "IDРодителя", Родитель
                                  FROM Menu WHERE [ID] = ?
                                  ORDER BY [Уровень меню], [Порядок отображения]',[$Id])[0];
        $data['uppermenu'] = $menu;
        $langs = DB::select('SELECT [Id языка] "ID", Наименование FROM Языки');
        $level = DB::select('SELECT [Уровень меню] "УровеньМеню"
                                   FROM Menu WHERE [ID] = ?
                                   ORDER BY [Уровень меню], [Порядок отображения]',[$Id])[0]->УровеньМеню;
        $data['level']=$level+1;
        $mens = [];
        $mens[0] = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню', [Язык подчинённого] 'ЯзыкПодчинённого', Тип
                                      FROM Menu WHERE ID=?",[$Id])[0];
        $level = $mens[0]->УровеньМеню;
        $i = 1;
        while($level!=1)
        {
            $punkt = DB::select("SELECT [ID родителя] 'IDРодителя' FROM Menu WHERE ID=?",[$Id])[0]->IDРодителя;
            $punkt = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню', [Язык подчинённого] 'ЯзыкПодчинённого',
                                       Тип FROM Menu WHERE ID=?",[$punkt])[0];
            $level = $punkt->УровеньМеню;
            $mens[$i] = $punkt;
            $id = $punkt->ID;
        }
        $mens = array_reverse($mens);
        $data['mens']=$mens;
        $data['langs']=$langs;
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
        if($data['menu']->IdСтатьи != null)
        {
            $article = DB::select("SELECT [Id статьи] 'IdСтатьи', Название, Текст,
                                         Тематика, [Id языка] 'IdЯзыка',[Краткая версия статьи] 'КраткаяВерсия',
                                         [Картинка статьи] 'КартинкаСтатьи'
                                         FROM Статья WHERE [Id статьи] = ?", [$data['menu']->IdСтатьи])[0];
            $data['article']=$article;
        }
        $langs = DB::select("SELECT [Id языка] 'IdЯзыка', Наименование
                                   FROM [Языки]");
        $data['langs'] = $langs;
        $mens = [];
        $mens[0] = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню', [Язык подчинённого] 'ЯзыкПодчинённого', Тип
                                      FROM Menu WHERE ID=?",[$name])[0];
        $level = $mens[0]->УровеньМеню;
        $i = 1;
        while($level!=1)
        {
            $punkt = DB::select("SELECT [ID родителя] 'IDРодителя' FROM Menu WHERE ID=?",[$name])[0]->IDРодителя;
            $punkt = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню', [Язык подчинённого] 'ЯзыкПодчинённого',
                                       Тип FROM Menu WHERE ID=?",[$punkt])[0];
            $level = $punkt->УровеньМеню;
            $mens[$i] = $punkt;
            $name = $punkt->ID;
        }
        $mens = array_reverse($mens);
        $data['mens']=$mens;
        return view('EditMenu',['data'=>$data]);
    }
    public function UpdateMenu($Id,Request $request){
        $date = getdate();
        //dd($request);
        //$month = ['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октабря','ноября','декабря'];
        $text = '<!DOCTYPE HTML><html><head><meta charset=\"utf-8\"><meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">'.'<title>'.$request->input('name').'</title>'.'</head>'.'<body>'.
        $request->input('text').'</body>'.'</html>';
        $upper = DB::select('SELECT [ID родителя] "ID" FROM Menu WHERE ID = ?',[$request->input('ID')])[0]->ID;
        DB::statement('EXECUTE UpdateMenu ?,?,?,?,?,?,?,?,?,?,?',
            [$request->input('ID'), $request->input('name'), $request->input('Language'),
            $request->input('URL'), $request->input('type'), $request->input('IDArticle'),
            $request->input('namearticle'), $request->input('topicarticle'),
            $request->input('description'), $request->input('idimage'),$text]);
        if($upper!=null)
            return redirect()->route('GetSubMenu',[$upper,$request->input('Language')]);
        else
            return  redirect()->route('GetMenuByLang',$request->input('Language'));
    }
}
