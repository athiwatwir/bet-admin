<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pgsoftgame extends Model
{
    use HasFactory;

    protected $fillable = [
        'operator_token', 'secret_key', 'salt', 'pgsoft_api_demo', 'pgsoft_api_domain', 'datagrab_api_domain', 'pgsoft_public_domain', 'history_interpreter', 'url_scheme', 'transfer_in', 'is_active', 'status'
    ];

    protected $hidden = [
        'is_active', 'status'
    ];
}
