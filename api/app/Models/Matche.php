<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matche extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'league_id',
        'start_time',
        'home_team',
        'away_team',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'start_time' => 'datetime',
    ];

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function bets()
    {
        return $this->hasMany(Bet::class);
    }
}
