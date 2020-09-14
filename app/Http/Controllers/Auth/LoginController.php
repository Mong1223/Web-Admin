<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function username()
    {
        return 'Имя';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public $token;

    public function login(Request $request)
    {
        $creditials = $request->only('Имя','Пароль');
        $bool = DB::select('SELECT Роль FROM Пользователь WHERE Имя=?',[$creditials['Имя']])[0]->Роль;
        if($bool=='ROLE_ADMIN')
        {
            //ctk1@tpu.ru
            if(Auth::attempt(['Имя'=>$creditials['Имя'],'password'=>$creditials['Пароль']],($request->input('remember')=='on') ? true : false))
            {
                $req = array(
                    'email'=>'ctk1@tpu.ru',
                    'password'=>$creditials['Пароль'],
                );
                $req = json_encode($req);
                $curl = curl_init('https://internationals.tpu.ru:8080/api/token/web-admin');
                curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"POST");
                curl_setopt($curl,CURLOPT_POSTFIELDS, $req);
                curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl,CURLOPT_HTTPHEADER,array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($req)
                ));
                $result = curl_exec($curl);
                $this->token = $result;
                curl_close($curl);
                session(['token'=>$result]);
                session(['email'=>'ctk1@tpu.ru']);
                return redirect()->intended('/home');
            }
            else{
                dd('Auth');
            }
        }
        else {
                dd('Role');
        }
        return redirect()->intended('dasboard');
    }
}
