<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class ApiGameConfig extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'api_game_id', 'key_name', 'method', 'value'
    ];
}
