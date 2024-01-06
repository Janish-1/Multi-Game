<?php

namespace App\Http\Controllers;

use App\Models\Player\Userdata;
use Illuminate\Http\Request;
use App\Models\fruitcutter;

class fruitgame extends Controller
{
    public function start_game(Request $request)
    {
        $playerid = $request->input('playerid');
        $playerlives = $request->input('playerlives');

        // Update or create a record in the fruitcutters table
        $fruitcutter = Fruitcutter::updateOrCreate(
            ['playerid' => $playerid],
            ['playerlives' => $playerlives]
        );

        // Update the in_game_status in the Userdata table
        $updatedUser = Userdata::where('playerid', $playerid)
            ->update(['in_game_status' => 1]);

        if ($updatedUser === 0) {
            $fruitcutter->delete(); // Rollback fruitcutter entry if userdata update fails
            return response()->json([
                'responseCode' => 500,
                'success' => false,
                'responseMessage' => 'Failed to start the game. Userdata update failed.',
            ]);
        }

        $responseData = [
            'player_id' => $playerid,
            'updated_lives' => $playerlives,
        ];

        return response()->json([
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Game started successfully.',
            'responseData' => $responseData,
        ]);
    }

    public function exit_game(Request $request)
    {
        $playerid = $request->input('playerid');

        // Update the in_game_status in the Userdata table
        $updatedUser = Userdata::where('playerid', $playerid)
            ->update(['in_game_status' => 0]);

        if ($updatedUser === 0) {
            return response()->json([
                'responseCode' => 500,
                'success' => false,
                'responseMessage' => 'Failed to exit the game. Userdata update failed.',
            ]);
        }

        // Delete records in fruitcutters table where playerid matches
        $deletedRows = Fruitcutter::where('playerid', $playerid)->delete();

        if ($deletedRows === 0) {
            return response()->json([
                'responseCode' => 500,
                'success' => false,
                'responseMessage' => 'No record found to delete in fruitcutters.',
            ]);
        }

        return response()->json([
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Game exited successfully.',
            'responseData' => ['player_id' => $playerid],
        ]);
    }

    public function set_score(Request $request)
    {
        $playerid = $request->input('playerid');
        $fruitscore = $request->input('fruitscore');
    
        if (!is_numeric($fruitscore) || $fruitscore < 0) {
            return response()->json([
                'responseCode' => 400,
                'success' => false,
                'responseMessage' => 'Invalid score value. Score must be a non-negative number.',
            ]);
        }
    
        // Retrieve current score for the player
        $currentScore = Userdata::where('playerid', $playerid)->value('fruitscore');
    
        if ($currentScore === null || $fruitscore > $currentScore) {
            Userdata::where('playerid', $playerid)->update([
                'fruitscore' => $fruitscore
            ]);
    
            return response()->json([
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'High score updated successfully.',
                'responseData' => ['player_id' => $playerid, 'fruitscore' => $fruitscore],
            ]);
        } else {
            return response()->json([
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'New score is not higher than the current score. Score remains unchanged.',
                'responseData' => ['player_id' => $playerid, 'current_score' => $currentScore],
            ]);
        }
    }
      

    public function get_high_score(Request $request)
    {
        $playerid = $request->input('playerid');

        // Retrieve high score for the specified player
        $highScore = Userdata::where('playerid', $playerid)->first();

        if (!$highScore) {
            return response()->json([
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'High score not found for the specified player.',
            ]);
        }

        return response()->json([
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'High score retrieved successfully.',
            'responseData' => [
                'player_id' => $playerid,
                'fruitscore' => $highScore->fruitscore,
            ],
        ]);
    }
}
