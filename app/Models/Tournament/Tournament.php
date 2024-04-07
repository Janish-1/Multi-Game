<?php

namespace App\Models\Tournament;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        "tournament_id",
        "tournament_name",
        "prize_pool",
        "player_type",
        "winner",
        "time_start",
        "game_type",
        "entry_fee",
        "nooftables",
        "t_status",
        "rewards",
        ];
}
