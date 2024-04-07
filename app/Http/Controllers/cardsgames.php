<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player\Userdata;

class cardsgames extends Controller
{
    public function increaseRummyWins(Request $request)
    {
        $playerId = $request->input('player_id');

        $userData = Userdata::where('playerid', $playerId)->first();

        if ($userData) {
            $userData->rummywins += 1;
            $userData->save();

            return response()->json([
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Rummy wins increased successfully',
                'new_rummy_wins_count' => $userData->rummywins,
            ], 200);
        } else {
            return response()->json([
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'User data not found',
            ], 404);
        }
    }

    public function decreaseRummyWins(Request $request)
    {
        $playerId = $request->input('player_id');

        $userData = Userdata::where('playerid', $playerId)->first();

        if ($userData) {
            $userData->rummyloss += 1;
            $userData->save();

            return response()->json([
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Rummy wins decreased successfully',
                'new_rummy_wins_count' => $userData->rummyloss,
            ], 200);
        } else {
            return response()->json([
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'User data not found',
            ], 404);
        }
    }

    public function increaseTeenPattiWins(Request $request)
    {
        $playerId = $request->input('player_id');

        $userData = Userdata::where('playerid', $playerId)->first();

        if ($userData) {
            $userData->teenpattiwins += 1;
            $userData->save();

            return response()->json([
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Teen Patti wins increased successfully',
                'new_teenpatti_wins_count' => $userData->teenpattiwins,
            ], 200);
        } else {
            return response()->json([
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'User data not found',
            ], 404);
        }
    }

    public function decreaseTeenPattiWins(Request $request)
    {
        $playerId = $request->input('player_id');

        $userData = Userdata::where('playerid', $playerId)->first();

        if ($userData) {
            $userData->teenpattiloss += 1;
            $userData->save();

            return response()->json([
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Teen Patti wins decreased successfully',
                'new_teenpatti_wins_count' => $userData->teenpattiloss,
            ], 200);
        } else {
            return response()->json([
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'User data not found',
            ], 404);
        }
    }
}
