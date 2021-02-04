<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $fillable = [
        'phoneNumber',
        'sex',
        'height',
        'age',
        'weight',
        'complication',
        'profession',
        'sports',
        'bg'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
