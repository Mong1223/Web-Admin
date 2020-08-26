<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use Psr\Http\Message\RequestInterface;

class PageController extends Controller
{
    public function GetNews($menuid, $lang){
        $menu = DB::select("SELECT ID,Подчинённый, [Уровень меню] 'УровеньМеню',
                                  [Язык подчинённого] 'ЯзыкПодчинённого',Тип, Ссылка, [Порядок отображения] 'ПорядокОтображения',
                                  [ID статьи] 'IDCтатьи', [ID картинки] 'IDКартинки',[ID родителя] 'IDРодителя', Родитель
                                  FROM Menu WHERE [Уровень меню]=1 AND [Язык подчинённого]= ? ORDER BY [Уровень меню], [Порядок отображения]",
                                  [$lang]);
        $data['menu'] = $menu;
        $langs = DB::select('SELECT [ID Языка] "IDЯзыка", Наименование FROM Языки');
        $data['menulangs'] = $langs;
        $listpages = DB::select('Select DISTINCT Страница,[ID пункта меню] "IDПунктаМеню", [Пункт меню] "ПунктМеню" From ArticlesInfo Where [ID пункта меню]=? AND [Язык]=?', [$menuid,$lang]);
        $data['listpages']=$listpages;
        if(Count($listpages)==0){
            $listpages = DB::select("SELECT [Страница].[Название] 'Страница',[Представление меню].[Наименование] 'ПунктМеню',
                                           [Представление меню].[Id пункта меню] 'IDПунктаМеню'
                                           FROM [Страница] INNER JOIN [Страницы пункты меню]
                                           ON [Страница].[Id страницы]=[Страницы пункты меню].[Id страницы]
                                           INNER JOIN [Представление меню] ON [Страницы пункты меню].[Id пункта меню]
                                           =[Представление меню].[Id пункта меню]
                                           INNER JOIN [Языки] ON [Представление меню].[ID языка] = [Языки].[ID языка]
                                           WHERE [Представление меню].[ID пункта меню]=? AND [Языки].[Наименование]=?",[$menuid,$lang]);
            $data['listpages']=$listpages;
        }
        $listnews = DB::select('Select Страница, [ID пункта меню] "IDПунктаМеню", Язык,  [ID статьи] "IDСтатьи",
                                      [Название статьи] "НазваниеСтатьи", [Текст статьи] "ТекстСтатьи",
                                      [Время создания статьи] "ВремяСозданияСтатьи", [Краткая версия статьи] "КраткаяВерсия",
                                      Тематика, [Картинка статьи] "Картинка", [Пункт меню] "ПунктМеню"
                                      From ArticlesInfo Where [ID пункта меню]=? AND [Язык]=?', [$menuid,$lang]);
        $data['listnews']=$listnews;
        $data['ПунктМеню']=DB::select('SELECT ID, [Язык подчинённого] "ЯзыкПодчинённого" FROM Menu WHERE [ID]=? AND [Язык подчинённого]=?',[$menuid,$lang])[0];
        $menus = [];
        $menus[0] = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню', [Язык подчинённого] 'ЯзыкПодчинённого', Тип
                                      FROM Menu WHERE ID=?",[$menuid])[0];
        $level = $menus[0]->УровеньМеню;
        $i = 1;
        while($level!=1)
        {
            $punkt = DB::select("SELECT [ID родителя] 'IDРодителя' FROM Menu WHERE ID=?",[$menuid])[0]->IDРодителя;
            $punkt = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню', [Язык подчинённого] 'ЯзыкПодчинённого',
                                       Тип FROM Menu WHERE ID=?",[$punkt])[0];
            $level = $punkt->УровеньМеню;
            $menus[$i] = $punkt;
            $menuid = $punkt->ID;
        }
        $menus = array_reverse($menus);
        $data['menus']=$menus;
        $data['header']=true;
        //dd($data);
        return view ('News',['data'=>$data]);
    }
    public function CreateNews($MenuName,$PageName){
        $data = [];
        $menus = [];
        $menuid = DB::select('SELECT [ID пункта меню] "ID" FROM ArticlesInfo WHERE [Пункт меню]=?',[$MenuName])[0]->ID;
        $menus[0] = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню', [Язык подчинённого] 'ЯзыкПодчинённого', Тип
                                      FROM Menu WHERE ID=?",[$menuid])[0];
        $level = $menus[0]->УровеньМеню;
        $i = 1;
        while($level!=1)
        {
            $punkt = DB::select("SELECT [ID родителя] 'IDРодителя' FROM Menu WHERE ID=?",[$menuid])[0]->IDРодителя;
            $punkt = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню', [Язык подчинённого] 'ЯзыкПодчинённого',
                                       Тип FROM Menu WHERE ID=?",[$punkt])[0];
            $level = $punkt->УровеньМеню;
            $menus[$i] = $punkt;
            $menuid = $punkt->ID;
        }
        $menus = array_reverse($menus);
        $data['menus']=$menus;
        if($PageName!=" "){
            $Page = DB::select('SELECT DISTINCT [Название] "Страница",[Наименование] "Язык" FROM [Страница] INNER JOIN
                                      [Языки] ON [Страница].[ID языка] = [Языки].[Id языка] WHERE Название=?',[$PageName]);
            $data['page'] = $Page[0];
            $data['Страница'] = $data['page']->Страница;
            $data['Язык'] = $data['page']->Язык;
            $Menu = DB::select('SELECT ID, Подчинённый, [Уровень меню] "УровеньМеню", [Язык подчинённого] "ЯзыкПодчинённого",
                                      Тип, Ссылка, [Порядок отображения] "ПорядокОтображения", [ID статьи] "IDСтатьи",
                                      [ID картинки] "IDКартинки", [ID родителя] "IDРодителя", Родитель
                                      FROM Menu WHERE [Подчинённый] = ?',[$MenuName])[0];
            $data['menu'] = $Menu;
            $langs = DB::select('SELECT [ID Языка] "IDЯзыка", Наименование FROM Языки');
            $data['menulangs'] = $langs;
            return view('CreateNews',['data'=>$data]);
        }
        else{
            $Menu = DB::select('SELECT * FROM Menu WHERE [Подчинённый] = ?',[$MenuName])[0];
            $titles = ['ID','Подчинённый','УровеньМеню','ЯзыкПодчинённого','Тип','Ссылка','ПорядокОтображения','IDСтатьи','IDКартинки','IDРодителя','Родитель'];
            $j=0;
            $data = [];
            foreach ($Menu as $item){
                $data['menu'][$titles[$j]] = $item;
                $j++;
            }
            $langs = DB::select('SELECT [ID Языка] "IDЯзыка", Наименование FROM Языки');
            $data['menulangs'] = $langs;
            return view('CreateNews',['data'=>$data]);
        }
    }
    public function SaveNews(Request $request){
        $date = getdate();
        $month = ['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октабря','ноября','декабря'];
        $text = '<!DOCTYPE HTML><html><head><meta charset=\"utf-8\"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0">'.'<title>'.$request->input('name').'</title>'.'</head>'.'<body>'.
            '<time datetime="'.$date['year'].'-'.$date['mon'].'-'.$date['mday'].'" title="'.($date['hours']+7).':'.$date['minutes'].', '.$date['mday'].' '.$date['month'].' '. $date['year'].'">'.$date['mday'].' '.$month[$date['mon']-1].' '.$date['year'].'</time>'. $request->input('text').'</body>'.'</html>';
        DB::statement('EXECUTE AddArticle ?,?,?,?,?,?',[$request->input('name'),$text,
            $request->input('topic'),$request->input('language'),$request->input('description'),$request->input('idimage')]);
        if($request->input('page')!=null){
            DB::statement('EXECUTE AddArticlesInPages ?, ?',[$request->input('page'),$request->input('name')]);
        }
        else{
            DB::statement('DECLARE @IdPage UNIQUEIDENTIFIER
                                 SELECT @IdPage=[Id статьи]
                                 FROM Статья
                                 WHERE [Название]=?
                                 INSERT INTO [Статьи пункты меню]([Id статьи], [Id пункта меню])
                                 VALUES(@IdPage,?)',[$request->input('name'),$request->input('IDMenu')]);
        }
        $menuid = DB::select('SELECT ID FROM Menu WHERE Подчинённый=?',[$request->input('menupunct')])[0]->ID;
        return redirect()->route('GetNews',[$menuid,$request->input('language')]);
    }
    public function SaveImage(Request $request){
        $file = $request->file;
        $filecontent = $file->openFile()->fread($file->getSize());
        $pdo = DB::connection()->getPdo();
        $sql = "INSERT INTO [Медиа](Данные) VALUES (CONVERT(varbinary(max), ?))";
        $stmt = $pdo->prepare($sql);
        $stmt->setAttribute(\PDO::SQLSRV_ATTR_ENCODING, \PDO::SQLSRV_ENCODING_BINARY);
        $stmt->bindValue(1, $filecontent);
        $stmt->execute();
        $url = 'http://109.123.155.178:8080/api/media/img/';
        $id = DB::select('SELECT [Id Медиа] FROM [Медиа] ORDER BY [Время создания] DESC');
        foreach ($id[0] as $elem){
            $id = $elem;
        }
        $url = $url . $id;
        return $url;
    }//Тут всё работает не трогать!!!
    public function DeleteNews($Id){
        $article = DB::select('SELECT [Id пункта меню] "IdПунктаМеню", Язык FROM ArticlesInfo WHERE [Id статьи] = ?',[$Id])[0];
        DB::statement('EXECUTE DeleteArticle ?',[$Id]);
        return redirect()->route('GetNews',[$article->IdПунктаМеню,$article->Язык]);
    }
    public function CreatePage($menuid,$lang){
        $data['menuid']=$menuid;
        $data['lang']=$lang;
        $langs = DB::select('SELECT [ID Языка] "IDЯзыка", Наименование FROM Языки');
        $data['menulangs'] = $langs;
        return view('CreatePage',['data'=>$data]);
    }
    public function SavePage(Request $request){
        DB::statement('EXECUTE AddPage ?,?',[$request->input('name'),$request->input('menulang')]);
        DB::statement('EXECUTE AddPageMenu ?,?',[$request->input('name'),$request->input('menuid')]);
        return redirect()->route('index');
    }
    public function DeletePage($Name){
        DB::statement('EXECUTE DeletePage ?',[$Name]);
        return redirect()->route('index');
    }
    public function EditNews($id)
    {
        $news = DB::select('SELECT [Id статьи] "IdСтатьи", Страница, [Пункт меню] "ПунктМеню", Язык, [Название статьи] "НазваниеСтатьи", [Текст статьи] "ТекстСтатьи", [Краткая версия статьи] "КраткаяВерсия",
        Тематика, [Картинка статьи] "Картинка" FROM ArticlesInfo WHERE [Id статьи]=?',[$id])[0];
        $langs = DB::select('SELECT [ID Языка] "IDЯзыка", Наименование FROM Языки');
        $data['menulangs'] = $langs;
        $data['news']=$news;
        $menus = [];
        $menuid = DB::select('SELECT [ID пункта меню] "ID" FROM ArticlesInfo WHERE [Id статьи]=?',[$id])[0]->ID;
        $menus[0] = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню', [Язык подчинённого] 'ЯзыкПодчинённого', Тип
                                      FROM Menu WHERE ID=?",[$menuid])[0];
        $level = $menus[0]->УровеньМеню;
        $i = 1;
        while($level!=1)
        {
            $punkt = DB::select("SELECT [ID родителя] 'IDРодителя' FROM Menu WHERE ID=?",[$menuid])[0]->IDРодителя;
            $punkt = DB::select("SELECT ID, Подчинённый, [Уровень меню] 'УровеньМеню', [Язык подчинённого] 'ЯзыкПодчинённого',
                                       Тип FROM Menu WHERE ID=?",[$punkt])[0];
            $level = $punkt->УровеньМеню;
            $menus[$i] = $punkt;
            $menuid = $punkt->ID;
        }
        $menus = array_reverse($menus);
        $data['menus']=$menus;
        //dd($data);
        return view('EditNews',['data'=>$data]);
    }
    public function UpdateNews($id, Request $request)
    {
        $text = $request->input('text');
        DB::statement('UPDATE Статья
                             SET Название = ?, Текст = ?, [Краткая версия статьи] = ?, Тематика = ?, [Картинка статьи] = ?
                             WHERE [Id статьи] = ?',[$request->input('name'),$text,$request->input('description'),$request->input('topic'),$request->input('idimage'), $id]);
        $lang = DB::select('SELECT Язык FROM ArticlesInfo WHERE [Id статьи] = ?', [$id])[0]->Язык;
        $menuid = DB::select('SELECT ID FROM Menu WHERE Подчинённый=?',[$request->input('menupunct')])[0]->ID;
        return redirect()->route('GetNews',[$menuid,$lang]);
    }
}
