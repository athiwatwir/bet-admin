<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class StaffRole extends Model
{
    use HasFactory, Uuids;

    protected $table = 'staff_roles';

    protected $fillable = [
        'name', 'staff_role_permission_id', 'isactive', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function permission()
    {
        return $this->hasOne(StaffRolePermission::class);
    }
}
