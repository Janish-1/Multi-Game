<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spinwheel extends Model
{
    protected $fillable = [
        'player_id',
        'is_winner',
        'amount',
        'win_amount',
        'lose_amount',
        'pick',
    ];

    use HasFactory;
}
