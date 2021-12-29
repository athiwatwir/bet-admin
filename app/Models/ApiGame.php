<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class ApiGame extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'name', 'isactive', 'status'
    ];

    public function api_url()
    {
        return $this->hasMany(ApiGameUrl::class);
    }

    public function api_config()
    {
        return $this->hasMany(ApiGameConfig::class);
    }
}
