<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPgsoftgame extends Model
{
    use HasFactory;

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
