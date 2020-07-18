<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function GetNews($name1){
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
        if(Count($listpages)==0){
            $titles = ['Страница','ПунктМеню'];
            $listpages = DB::select("SELECT [Страница].[Название],[Представление меню].[Наименование] 'ПунктМеню'
                                           FROM [Страница] INNER JOIN [Страницы пункты меню]
                                           ON [Страница].[Id страницы]=[Страницы пункты меню].[Id страницы]
                                           INNER JOIN [Представление меню] ON [Страницы пункты меню].[Id пункта меню]
                                           =[Представление меню].[Id пункта меню]
                                           WHERE [Представление меню].[Наименование]=?",[$name1]);
            for($i=0;$i<Count($listpages);$i++){
                $j=0;
                $data['listpages']=[];
                foreach ($listpages[$i] as $element){
                    $data['listpages'][$i][$titles[$j]] = $element;
                    $j++;
                }
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
        $news = DB::select('SELECT [Статья].[Id статьи], Название, Наименование, Текст, Тематика, [Время создания], [Краткая версия статьи]
                                  FROM [Статьи пункты меню] INNER JOIN [Статья]
                                  ON [Статьи пункты меню].[ID статьи]=[Статья].[ID статьи] INNER JOIN [Представление меню]
                                  ON [Статьи пункты меню].[ID пункта меню]=[Представление меню].[ID пункта меню]
                                  WHERE [Представление меню].[Наименование] = ?',[$name1]);
        $titles = ['IDСтатьи','Статья','ПунктМеню','ТекстСтатьи','Тематика','ВремяСозданияСтатьи','КраткаяВерсия'];
        for($i=0;$i<Count($news);$i++){
            $data['news'][$i] = [];
            $j = 0;
            foreach ($news[$i] as $element){
                $data['news'][$i][$titles[$j]] = $element;
                $j++;
            }
        }
        $data['ПунктМеню']=$name1;
        return view ('index',['data'=>$data]);
    }
    public function CreateNews($MenuName,$PageName){
        if($PageName!=" "){
            $Page = DB::select('SELECT DISTINCT [Название],[Наименование] FROM [Страница] INNER JOIN
                                      [Языки] ON [Страница].[ID языка] = [Языки].[Id языка] WHERE Название=?',[$PageName]);
            $titles = ['Страница','Язык'];
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
            $Menu = DB::select('SELECT * FROM Menu WHERE [Подчинённый] = ?',[$MenuName])[0];
            $titles = ['ID','Подчинённый','УровеньМеню','ЯзыкПодчинённого','Тип','Ссылка','ПорядокОтображения','IDСтатьи','IDРодителя','Родитель'];
            $j=0;
            $data = [];
            foreach ($Menu as $item){
                $data['menu'][$titles[$j]] = $item;
                $j++;
            }
            $data['page'] = $Page;
            return view('CreateNews',['data'=>$data]);
        }
        else{
            $Menu = DB::select('SELECT * FROM Menu WHERE [Подчинённый] = ?',[$MenuName])[0];
            $titles = ['ID','Подчинённый','УровеньМеню','ЯзыкПодчинённого','Тип','Ссылка','ПорядокОтображения','IDСтатьи','IDРодителя','Родитель'];
            $j=0;
            $data = [];
            foreach ($Menu as $item){
                $data['menu'][$titles[$j]] = $item;
                $j++;
            }
            return view('CreateNews',['data'=>$data]);
        }
    }
    public function SaveNews(Request $request){
        $text = '<!DOCTYPE HTML><html><head><meta charset=\"utf-8\"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0">'.'<title>'.$request->input('name').'</title>'.'</head>'.'<body>'.
            $request->input('text').'</body>'.'</html>';
        DB::statement('EXECUTE AddArticle ?,?,?,?,?',[$request->input('name'),$text,
            $request->input('topic'),$request->input('language'),$request->input('description')]);
        if($request->input('page'!=null)){
            dd($request);
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
        return redirect()->route('GetNews',$request->input('menupunct'));
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
        $url = 'http://109.123.155.178:8080/media/img/';
        $id = DB::select('SELECT [Id Медиа] FROM [Медиа] ORDER BY [Время создания] DESC');
        foreach ($id[0] as $elem){
            $id = $elem;
        }
        $url = $url . $id;
        return $url;
    }
    public function DeleteNews($Id){
        DB::statement('EXECUTE DeleteArticle ?',[$Id]);
        return redirect()->route('index');
    }
    public function CreatePage($Menu){
        return view('CreatePage',['Menu'=>$Menu]);
    }
    public function SavePage(Request $request){
        $language = DB::select('SELECT [Язык подчинённого] FROM Menu WHERE [Подчинённый]=?',[$request->input('Menu')])[0];
        foreach ($language as $lang){
            $language = $lang;
        }
        DB::statement('EXECUTE AddPage ?,?',[$request->input('name'),$language]);
        DB::statement('EXECUTE AddPageMenu ?,?',[$request->input('name'),$request->input('Menu')]);
        return redirect()->route('index');
    }
    public function DeletePage($Name){
        DB::statement('EXECUTE DeletePage ?',[$Name]);
        return redirect()->route('index');
    }
}
