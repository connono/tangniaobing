<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodGlucose extends Model
{
    use HasFactory;

    protected $table = 'blood_glucose';

    protected $fillable = [
        'blood_glucose',
        'type'
    ];
}
