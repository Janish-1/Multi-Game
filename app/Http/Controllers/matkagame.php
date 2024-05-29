<?php

namespace App\Http\Controllers;

use App\Models\WebSetting\Websetting;
use Illuminate\Http\Request;
use App\Models\matkagames;
use App\Models\matkanumbers;
use App\Models\Player\Userdata;
use Carbon\Carbon;

class matkagame extends Controller
{
    public function luckyBallIndex()
    {
        $matkaGame = MatkaGames::where(function ($query) {
            $query->where('mstatus', 'lock')
                ->orWhere('mstatus', 'open');
        })->first();

        if ($matkaGame) {
            // If $matkaGame is not null, proceed with fetching related data
            $gameId = $matkaGame->mid;
            $matkaNumbers = matkanumbers::where('mid', $gameId)->get();

            $gamePicks = MatkaNumbers::where('mid', $gameId)
                ->select('mpick', 'mplayer')
                ->get();

            $pickCounts = $gamePicks->groupBy('mpick')->map(function ($group) {
                return $group->count();
            });

            return view('admin.luckyball')
                ->with('matkaGame', $matkaGame)
                ->with('matkaNumbers', $matkaNumbers)
                ->with('pickCounts', $pickCounts);
        } else {
            // If $matkaGame is null, send empty arrays
            return view('admin.luckyball')
                ->with('matkaGame', [])
                ->with('matkaNumbers', [])
                ->with('pickCounts', []);
        }
    }

    public function createMatkaGame(Request $request)
    {
        $mstatus = "open";

        $mid = mt_rand(100000, 999999);

        $matkaGame = MatkaGames::create([
            'mid' => $mid,
            'mstatus' => $mstatus,
        ]);

        if ($matkaGame) {

            Websetting::where('id', 1)
                ->update([
                    'lucky_num_status' => 0
                ]);

            $responseData = [
                'responseCode' => 201,
                'success' => true,
                'responseMessage' => 'Matka game created successfully.',
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

    public function leaderboard(Request $request)
    {
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
    public function pickaball(Request $request)
    {
        $gameId = $request->input('game_id');
        $playerId = $request->input('player_id');
        $menteramount = $request->input('bid_amount');
        $pickedBall = $request->input('picked_ball');

        $matkaGame = MatkaGames::where('mid', $gameId)->first();

        if (!$matkaGame) {
            return $this->gameNotFoundResponse();
        }

        if ($matkaGame->mstatus === 'open') {
            $isWinner = ($pickedBall == $matkaGame->mwinball);

            $userData = Userdata::where('playerid', $playerId)->first();

            if (!$userData || $userData->totalcoin < $menteramount) {
                return $this->insufficientCoinsResponse();
            }

            $userData->totalcoin -= $menteramount;
            $userData->save();
            $winamount = $matkaGame['mamount'];

            MatkaNumbers::create([
                'mid' => $gameId,
                'mpick' => $pickedBall, // Replace this with the appropriate value
                'mvalue' => $winamount,
                'mplayer' => $playerId,
                'mbid' => $menteramount,
                'winner' => $isWinner,
            ]);

            return response()->json([
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Ball picked successfully.',
                'pickedBall' => $pickedBall,
            ], 200);
        } else {
            return response()->json([
                'responseCode' => 400,
                'success' => false,
                'responseMessage' => 'Game is Inactive',
            ], 400);
        }
    }

    private function gameNotFoundResponse()
    {
        return response()->json([
            'responseCode' => 404,
            'success' => false,
            'responseMessage' => 'Matka game not found.',
            'responseData' => null,
        ], 404);
    }

    private function insufficientCoinsResponse()
    {
        return response()->json([
            'responseCode' => 400,
            'success' => false,
            'responseMessage' => 'Insufficient coins.',
            'responseData' => null,
        ], 400);
    }
    public function payoutNumbers(Request $request)
    {
        $matkaGame = MatkaGames::where('mstatus', 'lock')->first();
        $gameId = $matkaGame->mid;

        if (!$matkaGame) {
            return $this->gameNotFoundResponse();
        }

        $matkaGame->update([
            'mstatus' => 'closed',
        ]);

        $winningEntries = MatkaNumbers::where('mid', $gameId)
            ->where('winner', true)
            ->get();

        foreach ($winningEntries as $entry) {
            if ($entry->mvalue === null) {
                // If mvalue is null, perform a random pick from the numbers in mpick
                $mpickArray = explode(',', $entry->mpick);
                $randomNumber = $mpickArray[array_rand($mpickArray)];

                $entry->update([
                    'mvalue' => $randomNumber,
                ]);
            }

            $userData = Userdata::where('playerid', $entry->mplayer)->first();

            if ($userData) {
                $userData->totalcoin += $entry->mvalue;
                $userData->wincoin += $entry->mvalue;
                $userData->save();
            }
        }
        $matkaGame->save();

        Websetting::where('id', 1)
            ->update([
                'lucky_num_status' => 3
            ]);

        return response()->json([
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Payout processed successfully.',
            'winningEntries' => $winningEntries,
        ], 200);
    }
    public function makeGameInactive(Request $request)
    {
        $matkaGame = MatkaGames::where('mstatus', 'open')->first();

        if (!$matkaGame) {
            return $this->gameNotFoundResponse();
        }

        // Make the game inactive
        $matkaGame->mstatus = "lock";
        $matkaGame->save();

        Websetting::where('id', 1)
            ->update([
                'lucky_num_status' => 1
            ]);

        return response()->json([
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Game set locked.',
        ], 200);
    }
    public function gamepicks(Request $request)
    {
        $gameId = $request->input('mid');

        $gamePicks = MatkaNumbers::where('mid', $gameId)
            ->select('mpick', 'mplayer')
            ->get();

        if ($gamePicks->isEmpty()) {
            return response()->json([
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'No picks available for this game.',
            ], 404);
        }

        $pickCounts = $gamePicks->groupBy('mpick')->map(function ($group) {
            return $group->count();
        });

        return response()->json([
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Number of players who picked each ball retrieved successfully.',
            'responseData' => $pickCounts,
        ], 200);
    }
    public function increaseWins(Request $request)
    {
        $playerId = $request->input('player_id');

        $userData = Userdata::where('playerid', $playerId)->first();

        if ($userData) {
            $userData->matkawins += 1;
            $userData->save();

            return response()->json([
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Wins increased successfully',
                'new_wins_count' => $userData->matkawins,
            ], 200);
        } else {
            return response()->json([
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'User data not found',
            ], 404);
        }
    }
    public function increaseLosses(Request $request)
    {
        $playerId = $request->input('player_id');

        $userData = Userdata::where('playerid', $playerId)->first();

        if ($userData) {
            $userData->matkaloss += 1;
            $userData->save();

            return response()->json([
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Losses increased successfully',
                'new_losses_count' => $userData->matkaloss,
            ], 200);
        } else {
            return response()->json([
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'User data not found',
            ], 404);
        }
    }
    public function setwinner(Request $request)
    {
        $mid = $request->input('mid');
        $mwinball = $request->input('mwinball');

        // Update matkagames
        $gameUpdated = matkagames::where('mid', $mid)->update([
            'mwinball' => $mwinball
        ]);

        // Update matkanumbers
        $numbersUpdated = matkanumbers::where('mid', $mid)->update([
            'mvalue' => ($mwinball) * 8,
        ]);

        matkanumbers::where('mid', $mid)
            ->where('mpick', $mwinball) // Add this condition
            ->update([
                'winner' => 1,
            ]);

        if ($gameUpdated && $numbersUpdated) {
            return response()->json([
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Winner set successfully',
            ], 200);
        } else {
            return response()->json([
                'responseCode' => 500,
                'success' => false,
                'responseMessage' => 'Failed to set winner',
            ], 500);
        }
    }
    public function closegame(Request $request)
    {
        $gamefound = matkagames::where('mstatus', 'open')
            ->orWhere('mstatus', 'lock')
            ->first();

        if ($gamefound) {
            $gamefound->update([
                'mstatus' => 'closed',
            ]);

            Websetting::where('id', 1)
                ->update([
                    'lucky_num_status' => 2
                ]);

            return response()->json([
                'responseCode' => 200,
                'success' => true,
                'responseMessage' => 'Game closed successfully',
            ], 200);
        } else {
            return response()->json([
                'responseCode' => 404,
                'success' => false,
                'responseMessage' => 'No open or locked games found',
            ], 404);
        }
    }
    public function activeluckynumber(Request $request)
    {
        // Find the Matka game by ID
        $matkaGame = MatkaGames::where('mstatus', 'open')->first(); // Include 'matkaNumbers'
        $gameId = $matkaGame->mid;
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

    public function statuschecker(Request $request)
    {
        $game1 = matkagames::where('mstatus', 'open')->first();
        $game2 = matkagames::where('mstatus', 'lock')->first();

        if ($game1) {
            $time_started = $game1->created_at;
            $created_at = Carbon::parse($time_started);
            $hoursPassed = now()->diffInHours($created_at);

            if ($hoursPassed >= 4) {
                $game1->mstatus = 'lock';
                $game1->save();

                Websetting::where('id', 1)
                    ->update([
                        'lucky_num_status' => 1
                    ]);

                return response()->json([
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Game 1 locked successfully',
                    'data' => $game1 // You can include additional data if needed
                ], 200);
            }
        }

        if ($game2) {
            $time_started = $game2->created_at;
            $created_at = Carbon::parse($time_started);
            $minutesPassed = now()->diffInMinutes($created_at);

            if ($minutesPassed >= 30) {
                $gameId = $game2->mid;

                $game2->update([
                    'mstatus' => 'closed',
                ]);

                $winningEntries = MatkaNumbers::where('mid', $gameId)
                    ->where('winner', true)
                    ->get();

                foreach ($winningEntries as $entry) {
                    if ($entry->mvalue === null) {
                        // If mvalue is null, perform a random pick from the numbers in mpick
                        $mpickArray = explode(',', $entry->mpick);
                        $randomNumber = $mpickArray[array_rand($mpickArray)];

                        $entry->update([
                            'mvalue' => $randomNumber,
                        ]);
                    }

                    $userData = Userdata::where('playerid', $entry->mplayer)->first();

                    if ($userData) {
                        $userData->totalcoin += $entry->mvalue;
                        $userData->wincoin += $entry->mvalue;
                        $userData->save();
                    }
                }

                $game2->save();

                Websetting::where('id', 1)
                    ->update([
                        'lucky_num_status' => 3
                    ]);

                return response()->json([
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Game 2 closed and processed successfully',
                    'data' => $game2 // You can include additional data if needed
                ], 200);
            }
        }

        $getsettings = Websetting::where('id', 1)->first();
        $getstatuscode = $getsettings->lucky_num_status;

        if ($getstatuscode === null) {
            $responseData = [
                'responseCode' => 404,
                'success' => true,
                'responseMessage' => 'Invalid Status , Eliminate Lucky Number',
                'reponseData' => [
                    'responseCode' => $getstatuscode,
                ],
            ];

            return response()->json($responseData, 404);
        }

        if ($getstatuscode === 0) {
            $message = "Game Started";
        }

        if ($getstatuscode === 1) {
            $message = "Game Locked";
        }

        if ($getstatuscode === 2) {
            $message = "Game Closed/Error";
        }

        if ($getstatuscode === 3) {
            $message = "Start New Game";

            $mstatus = "open";

            $mid = mt_rand(100000, 999999);

            $matkaGame = MatkaGames::create([
                'mid' => $mid,
                'mstatus' => $mstatus,
            ]);

            if ($matkaGame) {

                Websetting::where('id', 1)
                    ->update([
                        'lucky_num_status' => 0
                    ]);

                $responseData = [
                    'responseCode' => 201,
                    'success' => true,
                    'responseMessage' => 'Matka game created successfully.',
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

        $responseData = [
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Found Success Status Code',
            'reponseData' => [
                'responseCode' => $getstatuscode,
            ],
        ];

        return response()->json($responseData, 200);
    }
    public function timeparser(Request $request)
    {
        $game1 = matkagames::where('mstatus', 'open')->first();
        $game2 = matkagames::where('mstatus', 'lock')->first();

        if ($game1) {
            $time_started = $game1->created_at;
            $created_at = Carbon::parse($time_started);
            $hoursPassed = now()->diffInHours($created_at);

            if ($hoursPassed >= 4) {
                $game1->mstatus = 'lock';
                Websetting::where('id', 1)
                    ->update([
                        'lucky_num_status' => 1
                    ]);

                return response()->json([
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Game 1 locked successfully',
                    'data' => $game1 // You can include additional data if needed
                ], 200);
            }
        }

        if ($game2) {
            $time_started = $game2->created_at;
            $created_at = Carbon::parse($time_started);
            $minutesPassed = now()->diffInMinutes($created_at);

            if ($minutesPassed >= 270) {
                $gameId = $game2->mid;

                $game2->update([
                    'mstatus' => 'closed',
                ]);

                $winningEntries = MatkaNumbers::where('mid', $gameId)
                    ->where('winner', true)
                    ->get();

                foreach ($winningEntries as $entry) {
                    if ($entry->mvalue === null) {
                        // If mvalue is null, perform a random pick from the numbers in mpick
                        $mpickArray = explode(',', $entry->mpick);
                        $randomNumber = $mpickArray[array_rand($mpickArray)];

                        $entry->update([
                            'mvalue' => $randomNumber,
                        ]);
                    }

                    $userData = Userdata::where('playerid', $entry->mplayer)->first();

                    if ($userData) {
                        $userData->totalcoin += $entry->mvalue;
                        $userData->wincoin += $entry->mvalue;
                        $userData->save();
                    }
                }

                $game2->save();

                Websetting::where('id', 1)
                    ->update([
                        'lucky_num_status' => 3
                    ]);

                return response()->json([
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Game 2 closed and processed successfully',
                    'data' => $game2 // You can include additional data if needed
                ], 200);
            }
        }

        if (!$game1 & !$game2) {
            $mstatus = "open";

            $mid = mt_rand(100000, 999999);

            $matkaGame = MatkaGames::create([
                'mid' => $mid,
                'mstatus' => $mstatus,
            ]);

            if ($matkaGame) {

                Websetting::where('id', 1)
                    ->update([
                        'lucky_num_status' => 0
                    ]);

                $responseData = [
                    'responseCode' => 201,
                    'success' => true,
                    'responseMessage' => 'Matka game created successfully.',
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

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'No specific actions taken',
            'data' => null // You can include additional data if needed
        ], 200);
    }
    public function playerpicks(Request $request)
    {
        $gameId = $request->input('mid');
        $playerid = $request->input('playerid');

        $gamePicks = MatkaNumbers::where('mid', $gameId)
            ->where('mplayer', $playerid)
            ->get();

        return response()->json([
            'responseCode' => 200,
            'success' => true,
            'responseMessage' => 'Number of Balls Picked by player.',
            'responseData' => $gamePicks,
        ], 200);
    }
    public function timeLeft(Request $request)
    {
        $game = matkagames::where('mstatus', 'open')->first();

        if (!$game) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'No open game found',
            ], 404);
        }

        $timeStarted = $game->created_at;
        $createdAt = Carbon::parse($timeStarted);

        // Add 4 hours to the created_at timestamp
        $adjustedCreatedAt = $createdAt->addHours(4);

        $remainingTimeInMinutes = now()->diffInMinutes($adjustedCreatedAt);

        $remainingHours = floor($remainingTimeInMinutes / 60);
        $remainingMinutes = $remainingTimeInMinutes % 60;

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Adjusted time left for the open game',
            'data' => [
                'remaining_time' => [
                    'hours' => $remainingHours,
                    'minutes' => $remainingMinutes,
                ],
                'game' => $game,
            ],
        ], 200);
    }
    public function getlastwin(Request $request)
    {
        $playerid = $request->input('playerid');
        $lastplayedgame = matkanumbers::where('mplayer', $playerid)
            ->orderBy('created_at', 'desc')
            ->first();
        if (!$lastplayedgame) {
            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'No Last Game Found',
            ]);
        }
        $lastplayedgameid = $lastplayedgame->mid;
        $playerpicks = matkanumbers::where('mplayer', $playerid)
            ->where('mid', $lastplayedgameid)
            ->get();
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'All Picks retrieved successfully',
            'data' => [
                'playerpicks' => $playerpicks,
            ],
        ]);
    }
}