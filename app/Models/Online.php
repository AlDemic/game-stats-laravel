<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Online extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'game_id',
        'date',
        'stat',
        'source'
    ];

    //connect with games
    public function game() {
        return $this->belongsTo(Game::class);
    }
}
