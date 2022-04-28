<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Maintenance extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'api_game_id', 'startdate', 'enddate', 'description', 'status', 'now'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function api_game() {
        return $this->belongsTo(ApiGame::class);
    }
}
