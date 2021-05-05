<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CBankAccount extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'bank_id', 'account_name', 'account_number', 'is_active', 'status'
    ];

    protected $hidden = [
        'status'
    ];
}
