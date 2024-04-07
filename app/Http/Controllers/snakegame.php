<?php

namespace App\Http\Controllers;

use App\Models\Player\Userdata;
use Illuminate\Http\Request;

class snakegame extends Controller
{
    public function increaseSnakeWin(Request $request)
    {
        $playerId = $request->playerId;

        // Find the player by ID
        $player = Userdata::where("playerid",$playerId);

        if ($player) {
            // Increment the snakewin counter
            $player->increment('snakewin');

            // Save the changes
            $player->save();

            // Return a response if needed
            return response()->json(['success' => true, 'message' => 'Snake win counter increased successfully']);
        } else {
            // Return an error response if the player is not found
            return response()->json(['error' => 'Player not found'], 404);
        }
    }

    public function increaseSnakeLoss(Request $request)
    {
        $playerId = $request->playerId;

        // Find the player by ID
        $player = Userdata::find("playerid",$playerId);

        if ($player) {
            // Increment the snakeloss counter
            $player->increment('snakeloss');

            // Save the changes
            $player->save();

            // Return a response if needed
            return response()->json(['success' => true, 'message' => 'Snake loss counter increased successfully']);
        } else {
            // Return an error response if the player is not found
            return response()->json(['error' => 'Player not found'], 404);
        }
    }
}