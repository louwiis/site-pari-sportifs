<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matche;
use App\Models\Bet;
use App\Models\BetLine;
use App\Models\UserBet;

class BetController extends Controller
{
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validator = validator($request->all(), [
            'league_id' => 'required|integer',
            'start_time' => 'required|date',
            'home_team' => 'required|string',
            'away_team' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $match = Matche::create($request->all());

        return response()->json($match, 201);
    }

    public function createBet(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validator = validator($request->all(), [
            'title' => 'required|string',
            'bet_lines' => 'required|array|min:2',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $match = Matche::find($id);

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

        $bet = $match->bets()->create([
            'title' => $request->title,
        ]);

        foreach ($request->bet_lines as $betLine) {
            $bet->betLines()->create([
                'title' => $betLine['title'],
                'odd' => $betLine['odd'],
                'status' => 'pending'
            ]);
        }

        return response()->json($bet, 201);
    }

    public function deleteBet($id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $bet = Bet::find($id);

        if (!$bet) {
            return response()->json([
                'message' => 'Bet not found.'
            ], 404);
        }

        $bet->betLines()->delete();

        $bet->delete();

        return response()->json([
            'message' => 'Bet deleted.'
        ], 200);
    }

    public function updateStatusBetLine(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validator = validator($request->all(), [
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $betLine = BetLine::find($id);

        if (!$betLine) {
            return response()->json([
                'message' => 'Bet line not found.'
            ], 404);
        }

        $betLine->update([
            'status' => $request->status,
        ]);

        $betLine->userBets()->update([
            'status' => $request->status,
        ]);

        // find user and update balance
        $user = $betLine->userBets()->first()->user;

        if ($request->status === 'won') {
            $user->update([
                'balance' => $user->balance + $betLine->odd * $betLine->userBets()->first()->amount
            ]);
        }

        return response()->json($betLine, 200);
    }

}
