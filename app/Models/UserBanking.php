<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\Uuids;

class UserBanking extends Model
{
    use HasFactory, Notifiable, Uuids;

    protected $fillable = [
        'user_id', 'bank_id', 'bank_account_name', 'bank_account_number', 'is_active', 'status'
    ];

    protected $hidden = [
        'status'
    ];
}
