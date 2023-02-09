<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'country',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function matches()
    {
        return $this->hasMany(Matche::class);
    }
}
