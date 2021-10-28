<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Support\Facades\Hash;

class PasswordOtp extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'user_id', 'ref', 'otp', 'status'
    ];

    protected $hidden = [
        'status'
    ];

    public function setOtpAttribute($value)
    {
        $this->attributes['otp'] = Hash::make($value);
    }
}
