<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class PlayingTransaction extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'user_id', 'type', 'game_name', 'hands', 'bet_amount', 'win_loss_amount', 'row_version'
    ];

    protected $hidden = [
        
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
