<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserBet;
use App\Models\BetLine;
use App\Models\Matche;

use Illuminate\Support\Facades\Validator;

class UserBetController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = $request->user();

        $validator = validator($request->all(), [
            'amount' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $bet = BetLine::find($id);

        if (!$bet) {
            return response()->json([
                'message' => 'Bet not found.'
            ], 404);
        }

        $betLines = BetLine::where('bet_id', $bet->bet_id)->get();

        $match = Matche::find($bet->bet->matche_id);

        if (!$match) {
            return response()->json([
                'message' => 'Match not found.'
            ], 404);
        }

        if ($match->start_time < now()) {
            return response()->json([
                'message' => 'Match has already started.'
            ], 400);
        }

        if ($user->balance < $request->amount) {
            return response()->json([
                'message' => 'Insufficient funds.'
            ], 400);
        }

        if ($bet->status !== 'pending') {
            return response()->json([
                'message' => 'Bet is not pending.'
            ], 400);
        }

        $user->balance -= $request->amount;
        $user->save();

        $userBet = UserBet::create([
            'user_id' => $user->id,
            'bet_line_id' => $bet->id,
            'odd' => $bet->odd,
            'status' => 'pending',
            'amount' => $request->amount,
        ]);

        foreach ($betLines as $betLine) {
            if ($betLine->id === $bet->id) {
                if ($bet->odd > 1.06) {
                    $bet->odd -= 0.05;
                    $bet->save();
                } else {
                    $bet->odd = 1.01;
                    $bet->save();
                }
            } else {
                $betLine->odd += 0.05;
                $betLine->save();
            }
        }

        echo $bet->odd;

        return response()->json([
            'message' => 'Bet placed successfully.',
            'userBet' => $userBet,
        ], 201);
    }
}
