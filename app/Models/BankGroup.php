<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class BankGroup extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'name', 'isactive', 'isdefault'
    ];

    protected $hidden = [
        
    ];

    public function banks()
    {
        return $this->hasMany(CBankAccount::class);
    }
}
