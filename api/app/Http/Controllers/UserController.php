<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserBet;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = validator($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 404);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 200);
    }

    public function register(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    public function me(Request $request)
    {
        return $request->user();
    }

    public function index()
    {
        return User::all();
    }

    public function create_bet(Request $request, $id)
    {
        $user = $request->user();

        $validator = validator($request->all(), [
            'amount' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $bet = BetLine::find($request->bet_line_id);

        if (!$bet) {
            return response()->json([
                'message' => 'Bet not found.'
            ], 404);
        }

        if ($bet->status !== 'pending') {
            return response()->json([
                'message' => 'Bet is not pending.'
            ], 400);
        }

        if ($user->balance < $request->amount) {
            return response()->json([
                'message' => 'Insufficient funds.'
            ], 400);
        }

        $user->balance -= $request->amount;
        $user->save();

        // takes the bet lines from the same match
        $betLines = BetLine::where('bet_id', $bet->bet_id)->get();

        // print them in the console
        foreach ($betLines as $betLine) {
            echo $betLine->title . ' ' . $betLine->odd . ' ' . $betLine->status;
        }

        $userBet = UserBet::create([
            'user_id' => $user->id,
            'bet_line_id' => $request->bet_line_id,
            'odd' => $bet->odd,
            'status' => 'pending',
            'amount' => $request->amount,
        ]);
    }
}
