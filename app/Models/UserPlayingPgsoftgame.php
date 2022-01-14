<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class UserPlayingPgsoftgame extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'user_id', 'type', 'game_name', 'hands', 'bet_amount', 'win_loss_amount', 'row_version'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
