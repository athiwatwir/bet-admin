<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class ApiGame extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'game_group_id', 'name', 'gamecode', 'url', 'logo', 'isactive', 'status'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function api_url()
    {
        return $this->hasMany(ApiGameUrl::class);
    }

    public function api_config()
    {
        return $this->hasMany(ApiGameConfig::class);
    }

    public function api_token()
    {
        return $this->hasMany(ApiGameToken::class);
    }
    
    public function game_group()
    {
        return $this->belongsTo(GameGroup::class);
    }
    
    public function wallet()
    {
        return $this->hasMany(Wallet::class);
    }
}
