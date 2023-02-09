<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    protected $fillable = [
        'matche_id',
        'title',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function match()
    {
        return $this->belongsTo(Matche::class);
    }

    public function betLines()
    {
        return $this->hasMany(BetLine::class);
    }
}
