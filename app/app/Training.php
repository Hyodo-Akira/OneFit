<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'user_id',
        'menu',
        'parts',
        'date',
        'weight1','rep1',
        'weight2','rep2',
        'weight3','rep3',
        'weight4','rep4',
        'weight5','rep5',
        'weight6','rep6',
        'weight7','rep7',
        'weight8','rep8',
        'weight9','rep9',
        'weight10','rep10',
    ];
}
