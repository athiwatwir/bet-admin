<?php

namespace App\Models;

use \App\Http\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Member extends Model
{
    use UsesUuid;

    protected $fillable = [
        'username', 'password', 'name' , 'phone' , 'currency' , 'how_to_know'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Mutator for hashing the password on save
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new ResetPasswordNotification($token));
    // }

    /**
     * @param $query
     * @param $name
     * @return mixed
     */
    public function scopePhone($query, $phone)
    {
        return $query->where('members.phone', 'LIKE', "%$phone%", 'or');
    }
}
