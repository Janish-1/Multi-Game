<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fruitcutter;

class fruitgame extends Controller
{
    public function start_game(Request $request){
        $playerid = $request->input('playerid');
        $playerlives = $request->input('playerlives');
        
        fruitcutter::where('playerid', $playerid)
                   ->update(['playerlives' => $playerlives])
                   ->update(['in_game' => 1]);
    }
}
