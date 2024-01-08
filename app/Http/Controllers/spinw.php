<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player\Userdata;
use Illuminate\Support\Facades\DB;
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
        $spinData = Spinwheel::where('player_id', $playerId)->where('is_paid', false)->get();
    
        if ($spinData->isNotEmpty()) {
            $responseData = [];
    
            foreach ($spinData as $spin) {
                $isWinner = $spin->is_winner;
                $amount = $spin->amount;
    
                // Calculate the change in totalcoin and wincoin based on the is_winner status
                $totalcoinChange = $isWinner ? $amount : -$amount;
                $wincoinChange = $isWinner ? $amount : 0;
    
                DB::transaction(function () use ($playerId, $totalcoinChange, $wincoinChange) {
                    Spinwheel::where('player_id', $playerId)->update(['is_paid' => true]);
    
                    Userdata::where('playerid', $playerId)->increment('totalcoin', $totalcoinChange);
                    Userdata::where('playerid', $playerId)->increment('wincoin', $wincoinChange);
                });
    
                $responseData[] = [
                    'player_id' => $playerId,
                    'is_winner' => $isWinner,
                    'amount' => $amount,
                ];
            }
    
            return response()->json([
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Reward updated based on spin results.',
                'responseData' => $responseData,
            ], 200);
        } else {
            $errorResponse = [
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'Spin data not found for the player or reward already sent.',
            ];
    
            return response()->json($errorResponse, 404);
        }
    }
    
    public function leaderboard(Request $request)
    {
        $leaderboard = Spinwheel::select('player_id', DB::raw('SUM(CASE WHEN is_winner = true THEN win_amount ELSE 0 END) as total_won'))
            ->where('is_paid', true)
            ->groupBy('player_id')
            ->orderByDesc('total_won')
            ->get();

        $responseData = [];
        foreach ($leaderboard as $entry) {
            if ($entry->total_won > 0) {
                $responseData[] = [
                    'player_id' => $entry->player_id,
                    'total_won' => $entry->total_won,
                ];
            }
        }

        $response = [
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Leaderboard fetched successfully.',
            'leaderboard' => $responseData,
        ];

        return response()->json($response, 200);
    }
}
