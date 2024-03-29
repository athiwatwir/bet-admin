<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class ApiGameToken extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'api_game_id', 'name', 'value'
    ];

    protected $hidden = [
        'api_game_id', 'created_at', 'updated_at'
    ];
}
