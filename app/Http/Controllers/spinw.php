<?php

namespace App\Http\Controllers;

use App\Models\WebSetting\Websetting;
use Illuminate\Http\Request;
use App\Models\Player\Userdata;
use Illuminate\Support\Facades\DB;
use App\Models\spinwheel;

class spinw extends Controller
{
    public function spinWheelIndex()
    {
        // Your logic for the Spin Wheel page goes here
        return view('admin.spinwheel'); // Replace 'admin.spinwheel' with the actual view name
    }

    public function setodds(Request $request)
    {
        $validatedData = $request->validate([
            'spinodds' => 'required|numeric|min:0|max:10',
        ]);

        $spinOdds = $validatedData['spinodds'];

        // Update or create the odds in the websettings table
        $websettings = Websetting::updateOrCreate(
            ['id' => 1], // Assuming there is only one row, adjust if needed
            ['spin_odds' => $spinOdds]
        );

        if ($websettings) {
            $response = [
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Spin Wheel odds set successfully.',
                'responseData' => ['spin_odds' => $spinOdds],
            ];
        } else {
            $response = [
                'responseCode' => 500,
                'success' => false,
                'responseMessage' => 'Failed to set Spin Wheel odds.',
                'responseData' => [],
            ];
        }

        return redirect('/admin/spinwheel');
    }

    public function makeSpin(Request $request)
    {
        $validatedData = $request->validate([
            'player_id' => 'required',
        ]);

        $randomnum = rand(1, 10);

        // Create spin entry in the Spinwheel model with the determined amount and is_winner field
        $spinEntry = Spinwheel::create([
            'player_id' => $validatedData['player_id'],
            'pick' => $randomnum,
        ]);

        $responseData = [
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Spin entry created successfully.',
            'win_number' => $randomnum,
            'spinEntry' => $spinEntry,
        ];

        return response()->json($responseData, 200);
    }

    public function setwinner(Request $request)
    {
        $validatedData = $request->validate([
            'win_amount' => 'required|numeric',
            'lose_amount' => 'required|numeric',
        ]);

        $win_amount = $validatedData['win_amount'];
        $lose_amount = $validatedData['lose_amount'];

        $websettings = Websetting::where('id', 1)->first();
        $spin_odds = $websettings->spin_odds;

        // Fetch entries before the changes
        $spinEntriesBefore = Spinwheel::whereNull('is_winner')->get();

        $updatedEntries = 0;

        foreach ($spinEntriesBefore as $spinEntry) {
            $randomnum = $spinEntry->pick;

            $winnumber = ($randomnum <= $spin_odds);

            if ($websettings) {
                $isWinner = $winnumber; // Adjust the range based on your spinsodds value
            } else {
                // Handle the case where websettings are not found
                $isWinner = false;
            }

            // Set the amount based on the is_winner field
            $amount = $isWinner ? $win_amount : $lose_amount;
            $id = $spinEntry->ID;
            // Update the entry
            Spinwheel::where('ID', $id)
                ->update([
                    'win_amount' => $win_amount,
                    'lose_amount' => $lose_amount,
                    'is_winner' => $isWinner,
                    'amount' => $amount,
                ]);

            $updatedEntries++;
        }

        // Fetch entries after the changes
        $spinEntriesAfter = Spinwheel::whereIn('ID', $spinEntriesBefore->pluck('ID'))->get();

        $responseData = [
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Spin entries updated successfully.',
            'updatedEntries' => $updatedEntries,
            'entriesBefore' => $spinEntriesBefore,
            'entriesAfter' => $spinEntriesAfter,
        ];

        return response()->json($responseData, $responseData['responseCode']);
    }

    public function setwinningnum(Request $request)
    {
        $validatedData = $request->validate([
            'win_amount' => 'required|numeric',
            'lose_amount' => 'required|numeric',
            'winningnum' => 'required|numeric',
        ]);

        $win_amount = $validatedData['win_amount'];
        $lose_amount = $validatedData['lose_amount'];
        $winningnum = $validatedData['winningnum'];

        // Fetch entries before the changes
        $spinEntriesBefore = Spinwheel::whereNull('is_winner')->get();

        $updatedEntries = 0;

        foreach ($spinEntriesBefore as $spinEntry) {
            $randomnum = $spinEntry->pick;

            if ($randomnum === $winningnum) {
                $isWinner = true; // Adjust the range based on your spinsodds value
            } else {
                // Handle the case where websettings are not found
                $isWinner = false;
            }

            // Set the amount based on the is_winner field
            $amount = $isWinner ? $win_amount : $lose_amount;
            $id = $spinEntry->ID;
            // Update the entry
            Spinwheel::where('ID', $id)
                ->update([
                    'win_amount' => $win_amount,
                    'lose_amount' => $lose_amount,
                    'is_winner' => $isWinner,
                    'amount' => $amount,
                ]);

            $updatedEntries++;
        }

        // Fetch entries after the changes
        $spinEntriesAfter = Spinwheel::whereIn('ID', $spinEntriesBefore->pluck('ID'))->get();

        $responseData = [
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Spin entries updated successfully.',
            'updatedEntries' => $updatedEntries,
            'entriesBefore' => $spinEntriesBefore,
            'entriesAfter' => $spinEntriesAfter,
        ];

        return response()->json($responseData, $responseData['responseCode']);
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
                    Userdata::where('playerid', $playerId)->increment('spinwins');
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
    public function getSpins(Request $request)
    {
        $playerid = $request->input('playerid');

        $userData = Userdata::where('playerid', $playerid)->first();

        if ($userData) {
            $spins = $userData->spins; // Retrieving spins
            $response = [
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Spins retrieved successfully',
                'responseData' => ['spins' => $spins]
            ];
        } else {
            $response = [
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'User data not found',
                'responseData' => []
            ];
        }

        return response()->json($response);
    }
    public function increaseSpins(Request $request)
    {
        $playerid = $request->input('playerid');
        $increaseBy = $request->input('increase_by');

        $userData = Userdata::where('playerid', $playerid)->first();

        if ($userData) {
            $userData->spins += $increaseBy;
            $userData->save();

            $response = [
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Spins increased successfully',
                'responseData' => ['new_spins' => $userData->spins]
            ];
        } else {
            $response = [
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'User data not found',
                'responseData' => []
            ];
        }

        return response()->json($response);
    }
    public function decreaseSpins(Request $request)
    {
        $playerid = $request->input('playerid');
        $decreaseBy = $request->input('decrease_by');

        $userData = Userdata::where('playerid', $playerid)->first();

        if ($userData) {
            $userData->spins -= $decreaseBy;
            $userData->save();

            $response = [
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Spins decreased successfully',
                'responseData' => ['new_spins' => $userData->spins]
            ];
        } else {
            $response = [
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'User data not found',
                'responseData' => []
            ];
        }

        return response()->json($response);
    }
    public function increaseAllSpins(Request $request)
    {
        $users = Userdata::all();

        foreach ($users as $user) {
            $user->spins += 1;
            $user->save();
        }

        $response = [
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Spins increased for all players by 1',
            'responseData' => []
        ];

        return redirect('/admin/spinwheel');
    }
    public function increaseSpinWins(Request $request)
    {
        $playerId = $request->input('player_id');

        $userData = Userdata::where('playerid', $playerId)->first();

        if ($userData) {
            $userData->spins += 1;
            $userData->spinwins += 1;
            $userData->save();

            $response = [
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Spinwins increased successfully',
                'responseData' => ['new_spinwins' => $userData->spinwins]
            ];
        } else {
            $response = [
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'User data not found',
                'responseData' => []
            ];
        }

        return response()->json($response);
    }

    public function increaseSpinLoss(Request $request)
    {
        $playerId = $request->input('player_id');

        $userData = Userdata::where('playerid', $playerId)->first();

        if ($userData) {
            $userData->spins += 1;
            $userData->spinloss += 1;
            $userData->save();

            $response = [
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Spinloss increased successfully',
                'responseData' => ['new_spinloss' => $userData->spinloss]
            ];
        } else {
            $response = [
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'User data not found',
                'responseData' => []
            ];
        }

        return response()->json($response);
    }
}
