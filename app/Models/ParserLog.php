<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParserLog extends Model
{
    protected $fillable = [
        'parser_title',
        'status'
    ];
}
