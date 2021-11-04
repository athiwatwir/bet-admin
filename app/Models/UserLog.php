<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class UserLog extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'user_id', 'activity', 'url' , 'description' , 'ipaddress', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
