<?php

namespace App\Models\Tournament;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentTablemulti extends Model
{
    use HasFactory;

    protected $fillable = [
        "tournament_id",
        "table_id",
        "game_name",
        "player_id1",
        "player_id2",
        "player_id3",
        "player_id4",
        "player_type",
        "winner",
        ];
}
