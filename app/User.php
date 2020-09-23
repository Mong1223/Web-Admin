<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'Пользователь';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->Пароль;
    }

    public function getAuthIdentifier()
    {
        return $this->{'Id Пользователя'};
    }

    public function getAuthIdentifierName()
    {
        return 'Id Пользователя';
    }

    protected $primaryKey = 'Id Пользователя';

    protected $fillable = [
        'Фамилия',
        'Имя',
        'Отчество',
        'Пароль',
        'remember_token',
        'Роль',
        'Пол' ,
        'ID языка',
        'refresh salt',
        'Provider',
        'Подтвержден',
        'Номер группы'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'Id Пользователя','Пароль', 'remember_token', 'Роль', 'Пол' , 'ID языка', 'refresh salt','Provider','Подтвержден'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
