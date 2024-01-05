<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player\Userdata;
use App\Models\spinwheel;

class spinw extends Controller
{
    public function makeSpin(Request $request)
    {
        $validatedData = $request->validate([
            'player_id' => 'required',
            'win_amount' => 'required|numeric',
            'lose_amount' => 'required|numeric',
        ]);

        // Simulating 2 in 10 odds (20% chance of winning)
        $isWinner = (rand(1, 10) <= 2); // If random number <= 2, it's a win

        // Set the amount based on the is_winner field
        $amount = $isWinner ? $validatedData['win_amount'] : $validatedData['lose_amount'];

        // Create spin entry in the Spinwheel model with the determined amount and is_winner field
        $spinEntry = Spinwheel::create([
            'player_id' => $validatedData['player_id'],
            'win_amount' => $validatedData['win_amount'],
            'lose_amount' => $validatedData['lose_amount'],
            'is_winner' => $isWinner,
            'amount' => $amount,
        ]);

        $responseData = [
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Spin entry created successfully.',
            'spinEntry' => $spinEntry,
        ];

        return response()->json($responseData, 200);
    }

    public function sendReward(Request $request)
    {
        $validatedData = $request->validate([
            'player_id' => 'required',
        ]);
    
        $playerId = $validatedData['player_id'];
        $spinData = Spinwheel::where('player_id', $playerId)->where('is_paid', false)->first();
    
        if ($spinData) {
            $isWinner = $spinData->is_winner;
            $amount = $spinData->amount;
    
            Spinwheel::where('player_id', $playerId)->update(['is_paid' => true]);
    
            // Update the totalcoin based on whether the player won or lost
            Userdata::where('playerid', $playerId)->update([
                'totalcoin' => Userdata::raw($isWinner ? 'totalcoin + ' . $amount : 'totalcoin - ' . $amount),
            ]);
    
            $responseData = [
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Reward sent based on spin result.',
                'responseData' => [
                    'player_id' => $playerId,
                    'is_winner' => $isWinner,
                    'amount' => $amount,
                ],
            ];
    
            return response()->json($responseData, 200);
        } else {
            $errorResponse = [
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'Spin data not found for the player or reward already sent.',
            ];
    
            return response()->json($errorResponse, 404);
        }
    }
}
