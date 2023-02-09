<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\League;

class LeagueController extends Controller
{
    public function index()
    {
        return League::all();
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string',
            'country' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $league = League::create($request->all());

        return response()->json($league, 201);
    }
}
