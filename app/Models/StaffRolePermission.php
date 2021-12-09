<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class StaffRolePermission extends Model
{
    use HasFactory, Uuids;

    protected $table = 'staff_role_permissions';

    protected $fillable = [
        'users', 'admins'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
