<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtilsController extends Controller
{
    public function ShowResetForm($token)
    {
        return view('PasswordResets',['token'=>$token]);
    }
    public function reset(\Illuminate\Http\Request $request)
    {
        $reg = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!&^%$#@_|\/]{8,}$/';
        $validateddata = $request->validate([
            'password'=>['confirmed','regex:'.$reg],
        ]);
        $req = array(
            'token'=>$request->input('token'),
            'password'=>$request->input('password'),
        );
        $req = json_encode($req,JSON_UNESCAPED_UNICODE);
        $curl = curl_init('https://internationals.tpu.ru:8080/api/auth/password/reset');
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($curl,CURLOPT_POSTFIELDS, $req);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_HTTPHEADER,array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($req)
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result);
        return view('test',['data'=>$result]);
    }
    public function userTable(){
        $users = DB::select('SELECT [ID группы] "IDгруппы",[Номер группы] "НомерГруппы", [Идентификатор группы] "ИдентификаторГруппы"
        From [Идентификатор учебной группы] "ИдентификаторГруппы"');

        return view('userSet',['user' =>$users]);

    }
    public function editUserTable($id,$idg, Request $req){
        $data['id']=$id;
        $data['idg']=$idg;
        //dd($req);
        $inputs = $req->all();
       // dd($inputs['idgroup']);
        DB::statement('UPDATE [Идентификатор учебной группы] Set [Идентификатор группы] = ? where [Идентификатор группы] =? and [ID группы] = ?',[$inputs['idgroup'],$id,$idg]);
        return redirect()->route('userSet');
    }
    public function ADDUserTable(Request $request){
        $input = $request->all();

        DB::statement('Insert into [Идентификатор учебной группы] ([ID группы],[Номер группы],[Идентификатор группы])
                            Values(NEWID(),?,?)', [$input['group'],$input['idgroup']]);
        return redirect()->route('userSet');
    }
    public function deleteGroup($id){
        //dd($id);
        DB::statement('Delete from [Идентификатор учебной группы] where [ID группы]=?',[$id]);
        return redirect()->route('userSet');
    }
}
