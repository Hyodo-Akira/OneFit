<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    protected $fillable = [
        'food_name',
        'calories',
        'protein',
        'fat',
        'carbs',
    ];

    public function foodRecords()
    {
        
        return $this->hasMany(FoodRecord::class);
    }
}
