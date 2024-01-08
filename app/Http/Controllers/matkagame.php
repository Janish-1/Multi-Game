<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\matkagames;
use App\Models\matkanumbers;
use App\Models\Player\Userdata;
use Illuminate\Support\Facades\DB;

class matkagame extends Controller
{
    public function createMatkaGame(Request $request)
    {
        $mname = $request->input('mname');
        $mstatus = $request->input('mstatus');
        $mlocktime = $request->input('mlocktime');
        $mstarttime = $request->input('mstarttime');
        $mballs = $request->input('mballs');
        $mamount = $request->input('mamount');
        $mwinball = $request->input('mwinball');
        $menteramount = $request->input('menteramount');

        // Generate a random 6-digit number for 'mid'
        $mid = mt_rand(100000, 999999);

        $matkaGame = MatkaGames::create([
            'mid' => $mid,
            'mname' => $mname,
            'mstatus' => $mstatus,
            'mclosed' => $mballs,
            'mlocktime' => $mlocktime,
            'mstarttime' => $mstarttime,
            'mballs' => $mballs,
            'mamount' => $mamount,
            'mwinball' => $mwinball,
            'menteramount' => $menteramount,
        ]);

        if ($matkaGame) {
            $matkaNumbersData = [];
            for ($i = 1; $i <= $mballs; $i++) {
                $matkaNumbersData[] = [
                    'mid' => $mid,
                    'mname' => $mname,
                    'mvalue' => $i,
                ];
            }

            MatkaNumbers::insert($matkaNumbersData);

            $responseData = [
                'responseCode' => 201,
                'success' => true,
                'responseMessage' => 'Matka game and numbers created successfully.',
                'responseData' => $matkaGame, // Include the created Matka game data in the response
            ];

            return response()->json($responseData, 201); // HTTP status code 201 for successful resource creation
        } else {
            $errorResponse = [
                'responseCode' => 500,
                'success' => false,
                'responseMessage' => 'Failed to create Matka game.',
                'responseData' => null,
            ];

            return response()->json($errorResponse, 500);
        }
    }

    public function deleteMatkaGame(Request $request)
    {
        $mid = $request->input('mid');

        // Find the Matka game by 'mid'
        $matkaGame = MatkaGames::where('mid', $mid)->first();

        if (!$matkaGame) {
            $errorResponse = [
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'Matka game not found.',
                'responseData' => null,
            ];

            return response()->json($errorResponse, 404);
        }

        // Delete associated Matka numbers
        MatkaNumbers::where('mid', $mid)->delete();

        // Delete the Matka game
        $deleted = $matkaGame->delete();

        if ($deleted) {
            $responseData = [
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Matka game deleted successfully.',
                'responseData' => $matkaGame, // Optionally include deleted Matka game data in the response
            ];

            return response()->json($responseData, 200);
        } else {
            $errorResponse = [
                'responseCode' => 500,
                'success' => false,
                'responseMessage' => 'Failed to delete Matka game.',
                'responseData' => null,
            ];

            return response()->json($errorResponse, 500);
        }
    }

    public function deleteAllMatkaGames(Request $request)
    {
        // Delete all Matka numbers
        $deletedNumbers = MatkaNumbers::truncate(); // Truncate to delete all records efficiently

        // Delete all Matka games
        $deletedGames = MatkaGames::truncate(); // Truncate to delete all records efficiently

        if ($deletedGames && $deletedNumbers) {
            $responseData = [
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'All Matka games and numbers deleted successfully.',
                'responseData' => null,
            ];

            return response()->json($responseData, 200);
        } else {
            $errorResponse = [
                'responseCode' => 500,
                'success' => false,
                'responseMessage' => 'Failed to delete all Matka games and numbers.',
                'responseData' => null,
            ];

            return response()->json($errorResponse, 500);
        }
    }
    public function pickBall(Request $request)
    {
        $gameId = $request->input('game_id'); // Assuming 'game_id' is sent in the request
        $playerId = $request->input('player_id'); // Assuming 'player_id' is sent in the request
        $pickedBall = $request->input('picked_ball'); // User input for the picked ball

        // Find the Matka game by ID
        $matkaGame = MatkaGames::where('mid', $gameId)->first();

        if (!$matkaGame) {
            $errorResponse = [
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'Matka game not found.',
                'responseData' => null,
            ];

            return response()->json($errorResponse, 404);
        }

        $winBall = $matkaGame->mwinball; // Get the winning ball number

        $isWinner = ($pickedBall == $winBall); // Check if the picked ball matches the win ball

        // Fetch userdata to check totalcoins
        $userData = Userdata::where('playerid', $playerId)->first();
        $totalCoins = $userData->totalcoin;
        $menteramount = $matkaGame->menteramount;
        $winCoin = $matkaGame->mamount; // Assuming this value is available in the MatkaGame model

        if ($totalCoins >= $menteramount) {
            // Deduct menteramount from totalcoins
            $userData->totalcoin -= $menteramount;
            $userData->save();
        } else {
            // Error response if totalcoins are insufficient
            $errorResponse = [
                'responseCode' => 400,
                'success' => false,
                'responseMessage' => 'Insufficient coins.',
                'responseData' => null,
            ];

            return response()->json($errorResponse, 400);
        }

        if ($isWinner) {
            // Update MatkaGames 'winner' column with player ID
            $matkaGame->update(['winner' => $playerId]);

            // Increment 'mopened' and decrement 'mclosed' in MatkaGames
            $matkaGame->increment('mopened');
            $matkaGame->decrement('mclosed');

            // Update 'mstatus' field to 'inActive'
            $matkaGame->mstatus = 'inActive';
            $matkaGame->save();

            // Increase wincoin to the winner's totalcoins
            $userData->totalcoin += $winCoin;
            $userData->totalcoin += $menteramount;
            $userData->wincoin += $winCoin;
            $userData->save();

            // Delete all MatkaNumbers associated with the game
            MatkaNumbers::where('mid', $gameId)->delete();

            $responseData = [
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Ball picked successfully. Player is a winner!',
                'pickedBall' => $pickedBall,
                'isWinner' => true,
            ];

            return response()->json($responseData, 200);
        } else {

            // Update 'playerid' column in MatkaNumbers with player ID
            MatkaNumbers::where('mid', $gameId)
                ->where('mvalue', $pickedBall)
                ->update(['mplayer' => $playerId]);

            // Increment 'mopened' and decrement 'mclosed' in MatkaGames
            $matkaGame->increment('mopened');
            $matkaGame->decrement('mclosed');

            $responseData = [
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Ball picked successfully. Player did not win.',
                'pickedBall' => $pickedBall,
                'isWinner' => false,
            ];

            return response()->json($responseData, 200);
        }
    }
    public function readOneMatkaGame(Request $request)
    {
        $gameId = $request->input('game_id'); // Assuming 'game_id' is sent in the request

        // Find the Matka game by ID
        $matkaGame = MatkaGames::where('mid', $gameId)->first(); // Include 'matkaNumbers'
        $matkaNumbers = matkanumbers::where('mid', $gameId)->get();

        if (!$matkaGame) {
            $errorResponse = [
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'Matka game not found.',
                'responseData' => null,
            ];

            return response()->json($errorResponse, 404);
        }

        $responseData = [
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Matka game found.',
            'responseData' => [
                'matkaGame' => $matkaGame, // Return the retrieved Matka game
                'matkaNumbers' => $matkaNumbers // Return associated MatkaNumbers
            ],
        ];

        return response()->json($responseData, 200);
    }

    public function readAllMatkaGames(Request $request)
    {
        // Retrieve all Matka games
        $matkaGames = MatkaGames::all();

        if ($matkaGames->isEmpty()) {
            $errorResponse = [
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'No Matka games found.',
                'responseData' => null,
            ];

            return response()->json($errorResponse, 404);
        }

        $responseData = [
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'All Matka games retrieved successfully.',
            'responseData' => $matkaGames,
        ];

        return response()->json($responseData, 200);
    }

    public function checkWinner(Request $request)
    {
        $gameId = $request->input('game_id'); // Assuming 'game_id' is sent in the request

        // Check if the game status is 'inactive' and if there is a winner for the given game ID
        $inactiveGame = MatkaGames::where('mid', $gameId)
            ->where('mstatus', 'inactive')
            ->exists();

        $winningPlayer = MatkaNumbers::where('mid', $gameId)
            ->exists();

        if (!$inactiveGame) {
            $errorResponse = [
                'responseCode' => 400,
                'success' => false,
                'responseMessage' => 'Game is either not inactive or not found.',
                'isWinner' => false,
            ];

            return response()->json($errorResponse, 400);
        }

        $isWinner = ($winningPlayer);

        $responseData = [
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Game is inactive and winner status checked.',
            'isWinner' => $isWinner,
        ];

        return response()->json($responseData, 200);
    }

    public function leaderboard(Request $request){
        $leaderboard = matkagames::select('winner', 'mamount')
            ->orderBy('winner')
            ->orderByDesc('mamount')
            ->get();
    
        $responseData = [];
        $winners = [];
        foreach ($leaderboard as $entry) {
            if (!isset($winners[$entry->winner])) {
                $winners[$entry->winner] = 0;
            }
            $winners[$entry->winner] += $entry->mamount;
        }
    
        foreach ($winners as $winner => $amount) {
            $responseData[] = [
                'player_id' => $winner,
                'win_amount' => $amount,
            ];
        }
    
        $response = [
            'responseCode' => 200,
            'responseMessage' => 'Leaderboard fetched successfully',
            'success' => true,
            'data' => $responseData,
        ];
    
        return response()->json($response);
    }
}
