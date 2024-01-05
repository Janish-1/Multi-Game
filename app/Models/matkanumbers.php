<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matkanumbers extends Model
{
    protected $fillable = [
        'mid',
        'mname',
        'mvalue',
        'mplayer',
    ];

    use HasFactory;
}
