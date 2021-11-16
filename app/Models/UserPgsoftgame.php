<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class UserPgsoftgame extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'user_id', 'player_session', 'operator_player_session'
    ];

    protected $hidden = [
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
