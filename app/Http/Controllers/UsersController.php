<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt;
use mysql_xdevapi\Exception;
use Psr\Http\Message\RequestInterface;

class UsersController extends Controller
{
    public function getUsers(){
        $users = Auth::user()::all();
       /*$users= DB::select('SELECT [Фамилия] "Фамилия", [Имя] "Имя", [Отчество] "Отчество",
          [Роль] "Роль", [Пол] "Пол",[Номер группы] "Группа" From [Пользователь]');*/
        return view('users',['users' =>$users]);
    }
    public function uploadFiles(Request $request)
    {
        $mssqlid = DB::SELECT('SELECT NEWID() "ID"')[0]->ID;
        $inputs = $request->all();
        $file = $request->file;
        $filecontent = $file->openFile()->fread($file->getSize());
        $pdo = DB::connection()->getPdo();
        $filename = $file->getClientOriginalName();
        $sql = "INSERT INTO [Документы]([ID документа], [Содержимое документа],[Название документа], [Название файла],[Дата загрузки документа])
                VALUES (:id, CONVERT(varbinary(max), :filecontent), N'".$inputs["name"]."',N'".$filename."', GETDATE())";
        $stmt = $pdo->prepare($sql);
        $stmt->setAttribute(\PDO::SQLSRV_ATTR_ENCODING, \PDO::SQLSRV_ENCODING_SYSTEM);
        $stmt->execute(array(':id'=>$mssqlid,':filecontent'=>$filecontent));
        DB::statement('INSERT INTO [Документы пользователя] VALUES (?,?)',[$inputs["id"],$mssqlid]);
        return 'ok';
    }
}
