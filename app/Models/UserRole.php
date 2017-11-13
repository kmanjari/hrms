<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $guarded = [];

    public function role()
    {
        return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }
}
