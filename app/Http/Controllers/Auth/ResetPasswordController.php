<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use http\Env\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

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
        if($result->status!=200)
        {
            $data = $result;
            return view('test',['data'=>$data]);
        }
        return view('test');
    }
}
