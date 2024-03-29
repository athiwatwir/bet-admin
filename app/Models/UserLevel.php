<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class UserLevel extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'name', 'limit_transfer', 'limit_withdraw' , 'limit_deposit' , 'isactive', 'isdefault', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function api_game() {
        return $this->hasMany(UserLevelApiGame::class);
    }
}
