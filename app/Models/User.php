<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Uuids;
use Illuminate\Support\Facades\Hash;

use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_level_id', 'username', 'password', 'name' , 'line' , 'phone' , 'currency' , 'how_to_know', 'how_to_know_desc' , 'status' , 'is_active', 'is_admin', 'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'is_admin', 'created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function scopePhone($query, $phone)
    {
        return $query->where('users.phone', 'LIKE', "%$phone%", 'or');
    }

    public function scopeUsername($query, $username)
    {
        return $query->where('users.username', 'LIKE', "%$username%", 'or');
    }

    public function scopeLine($query, $username)
    {
        return $query->where('users.line', 'LIKE', "%$line%", 'or');
    }
}
