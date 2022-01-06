<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class ApiGameUrl extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'api_game_id', 'name','url'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
