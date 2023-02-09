<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bet_line_id',
        'odd',
        'status',
        'amount',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'odd' => 'float',
        'amount' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function betLine()
    {
        return $this->belongsTo(BetLine::class);
    }
}
