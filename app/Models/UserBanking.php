<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserBanking extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id', 'bank_name', 'bank_account_name', 'bank_account_number', 'is_active', 'status'
    ];

    protected $hidden = [
        'status'
    ];
}
