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
    public function reset_high_score(Request $request)
    {
        $playerid = $request->input('playerid');

        $resetScore = Userdata::where('playerid', $playerid)->update(['fruitscore' => 0]);

        if (!$resetScore) {
            return response()->json([
                'responseCode' => 500,
                'success' => false,
                'responseMessage' => 'Failed to reset player high score.',
            ]);
        }

        return response()->json([
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Player high score reset successfully.',
            'responseData' => ['player_id' => $playerid, 'new_score' => 0],
        ]);
    }
    public function increase_player_lives(Request $request)
    {
        $playerid = $request->input('playerid');
        $extraLives = $request->input('extraLives');

        $currentLives = Fruitcutter::where('playerid', $playerid)->value('playerlives');

        if ($currentLives === null) {
            return response()->json([
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'Player not found.',
            ]);
        }

        $newLives = $currentLives + $extraLives;

        Fruitcutter::where('playerid', $playerid)->update(['playerlives' => $newLives]);

        return response()->json([
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Player lives increased successfully.',
            'responseData' => ['player_id' => $playerid, 'new_lives' => $newLives],
        ]);
    }
    public function decrease_player_lives(Request $request)
    {
        $playerid = $request->input('playerid');
        $lostLives = $request->input('lostLives');

        $currentLives = Fruitcutter::where('playerid', $playerid)->value('playerlives');

        if ($currentLives === null || $currentLives < $lostLives) {
            return response()->json([
                'responseCode' => 400,
                'success' => false,
                'responseMessage' => 'Insufficient lives or player not found.',
            ]);
        }

        $newLives = $currentLives - $lostLives;

        Fruitcutter::where('playerid', $playerid)->update(['playerlives' => $newLives]);

        return response()->json([
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Player lives decreased successfully.',
            'responseData' => ['player_id' => $playerid, 'new_lives' => $newLives],
        ]);
    }
    public function get_top_players(Request $request)
    {
        $limit = $request->input('limit', 10); // Default limit set to 10

        $topPlayers = Userdata::select('playerid', 'fruitscore')->orderBy('fruitscore', 'desc')->limit($limit)->get();

        if ($topPlayers->isEmpty()) {
            return response()->json([
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'No top players found.',
            ]);
        }

        return response()->json([
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Top players retrieved successfully.',
            'responseData' => $topPlayers,
        ]);
    }
    public function increment_fruit_win(Request $request)
    {
        $playerid = $request->input('playerid');

        $userData = Userdata::where('playerid', $playerid)->first();

        if (!$userData) {
            return response()->json([
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'Player not found.',
            ]);
        }

        $userData->increment('fruitwin');

        return response()->json([
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Fruit win count incremented successfully.',
            'responseData' => ['player_id' => $playerid, 'new_fruitwin_count' => $userData->fruitwin],
        ]);
    }
    public function decrement_fruit_lose(Request $request)
    {
        $playerid = $request->input('playerid');

        $userData = Userdata::where('playerid', $playerid)->first();

        if (!$userData) {
            return response()->json([
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'Player not found.',
            ]);
        }

        $userData->increment('fruitlose');

        return response()->json([
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Fruit lose count decremented successfully.',
            'responseData' => ['player_id' => $playerid, 'new_fruitlose_count' => $userData->fruitlose],
        ]);
    }
}
