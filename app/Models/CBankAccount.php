<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\Uuids;

class CBankAccount extends Model
{
    use HasFactory, Notifiable, Uuids;

    protected $fillable = [
        'bank_id', 'bank_group_id', 'account_name', 'account_number', 'is_active', 'status'
    ];

    protected $hidden = [
        'status'
    ];

    public function abank()
    {
        return $this->hasOne(Banks::class);
    }
}
