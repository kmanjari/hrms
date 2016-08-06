<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function employee()
    {
        return $this->hasOne(User::class, 'id', 'member_id');
    }

    public function manager()
    {
        return $this->hasOne(User::class, 'id', 'manager_id');
    }

    public function leader()
    {
        return $this->hasOne(User::class, 'id', 'leader_id');
    }
}
