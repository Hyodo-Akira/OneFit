<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodRecord extends Model
{
    // リレーション関数（食事記録がどのユーザーに属しているか）
    public function user()
    {
        // User は「多対1」の関係（1人のユーザーが複数の食事記録を持つ）
        return $this->belongsTo(User::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    // 一括で保存できる項目を指定
    protected $fillable = [
        'user_id',
        'food_id',
        'date',
        'time',
        'amount',
    ];

}
