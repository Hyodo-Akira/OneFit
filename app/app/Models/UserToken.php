<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $table = 'user_tokens'; // テーブル名

    protected $fillable = [
        'id',  // ユーザーID
        'rest_password_access_key',
        'rest_password_expire_data',
    ];

    public $timestamps = false; // もし created_at, updated_at が無ければ
}
