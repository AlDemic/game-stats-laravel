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

    //for route route binding(url instead of id)
    public function getRouteKeyName()
    {
        return 'url';
    }

    public function online() {
        return $this->hasMany(Online::class);
    }

    public function income() {
        return $this->hasMany(Online::class);
    }
}
