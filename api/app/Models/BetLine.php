<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'bet_id',
        'title',
        'odd',
        'status'
    ];

    public function bet()
    {
        return $this->belongsTo(Bet::class);
    }

    public function userBets()
    {
        return $this->hasMany(UserBet::class);
    }
}
