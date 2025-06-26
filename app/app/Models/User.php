<?php

namespace App\Models;

//ユーザー認証機能付きベースクラスを使う
use Illuminate\Foundation\Auth\User as Authenticatable;
//ララベルの通知機能（ユーザーへのメール通知など）を使う
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    //通知を送る機能
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rest_password_access_key',
        'rest_password_expire_data',
    ];
}
