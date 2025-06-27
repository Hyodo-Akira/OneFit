<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    //タイムスタンプ自動管理をオフ
    public $timestamps = false;

    //プライマリキーの指定(idではないため)
    protected $primaryKey = 'email';

    //プライマリキーが自動増分ではないことを指定
    public $incrementing = false;

    // 主キーの型が文字列であることを指定
    protected $keyType = 'string';

    //テーブル名を指定（ララベルはデフォルトでこの名前を使う）
    protected $table = 'password_resets';

    //保存可能なカラム
    protected $fillable = [
        'email',  
        'token',
        'created_at',
    ];
}
