<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = "foods";

    protected $fillable = [
        'name',
        'gi',
        'energy',
        'carbohydrate',
        'axunge',
        'protein'
    ];

    public function complications()
    {
        return $this->belongsToMany('App\Models\Complication', 'food_complication', 'food_id', 'complication_id');
    }
}
