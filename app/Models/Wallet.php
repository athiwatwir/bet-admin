<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\Uuids;

class Wallet extends Model
{
    use HasFactory, Notifiable, Uuids;

    protected $fillable = [
        'user_id', 'api_game_id', 'amount', 'currency', 'is_default', 'status'
    ];

    protected $hidden = [
        'status'
    ];
}
