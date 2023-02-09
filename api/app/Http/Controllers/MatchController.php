<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Matche;
use App\Models\Bet;

class MatchController extends Controller
{
    public function index()
    {
        return Matche::with('league')
            ->where('start_time', '>', now())
            ->orderBy('start_time', 'asc')
            ->limit(50)
            ->get();
    }

    public function show($id)
    {
        return Matche::with('league', 'bets.betLines')
            ->where('id', $id)
            ->first();
    }

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
}
