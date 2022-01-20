<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class GameGroup extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'name', 'is_active', 'status'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function api_game()
    {
        return $this->hasMany(ApiGame::class);
    }
}
