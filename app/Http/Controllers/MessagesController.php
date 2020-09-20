<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function SendMessage(Request $request)
    {
        $input = $request->all();
        $req = array(
            'language'=>$input["language"],
            'title'=>$input["title"],
            'message'=>$input["message"],
            'email'=>$input["email"],
            'token'=>$input["token"],
        );
        $req = json_encode($req,JSON_UNESCAPED_UNICODE);
        $curl = curl_init('https://internationals.tpu.ru:8080/api/notification');
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
        return $result;
    }
}
