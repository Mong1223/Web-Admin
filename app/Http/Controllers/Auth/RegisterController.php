<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'Фамилия' => ['required', 'string', 'max:255'],
            //'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'Имя'=>['required', 'string', 'max:255'],
            'Отчество'=>['required', 'string', 'max:255'],
            'Пароль' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function register(Request $request)
    {
        $data['name'] = $request->input('name');
        $data['secondname'] = $request->input('secondname');
        $data['thirdname'] = $request->input('thirdname');
        $data['password'] = $request->input('password');
        $data['role'] = 'ROLE_ADMIN';
        $data['sex'] = 'Male';
        $data['lang'] = 'ad305703-9eaa-452c-9299-125a545ec811';
        $data['salt'] = null;
        $data['provider'] = 'local';
        $data['confirm'] = 1;
        $this->create($data);
        $user = User::all()->where('Имя','==',$request->input('name'))->first();
        DB::statement('INSERT INTO [Электронная почта] VALUES(NEWID(),?,?)',[$request->input('email'), $user->{'Id Пользователя'}]);
        return redirect()->intended('dashboard');
    }

    protected function create(array $data)
    {
        return User::create([
            'Имя' => $data['name'],
            'Фамилия' => $data['secondname'],
            'Отчество' => $data['thirdname'],
            //'email' => $data['email'],
            'Роль' => $data['role'],
            'Пол' => $data['sex'],
            'ID языка' => $data['lang'],
            'refresh salt' => $data['salt'],
            'Provider' => $data['provider'],
            'Подтвержден' => $data['confirm'],
            'Пароль' => Hash::make($data['password'])
        ]);
    }
}
