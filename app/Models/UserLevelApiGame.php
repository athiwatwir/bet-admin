<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class UserLevelApiGame extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'user_level_id', 'api_game_id', 'isactive' , 'status'
    ];
}
