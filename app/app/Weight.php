<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    protected $fillable = [
        'user_id',
        'weight',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
