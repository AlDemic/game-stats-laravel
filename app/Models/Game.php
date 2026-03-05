<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'title',
        'year',
        'pic',
        'url'
    ]; 

    public function online() {
        return $this->hasMany(Online::class);
    }

    public function income() {
        return $this->hasMany(Online::class);
    }
}
