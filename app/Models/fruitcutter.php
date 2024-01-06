<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fruitcutter extends Model
{
    protected $fillable = [
        'playerid',
        'playerscore',
        'playerlives',
    ];

    use HasFactory;
}
