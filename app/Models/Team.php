<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function employee()
    {
        return $this->hasOne('\App\Models\Employee', 'id', 'member_id');
    }

    public function manager()
    {
        return $this->hasOne('\App\Models\Employee', 'id', 'manager_id');
    }

    public function leader()
    {
        return $this->hasOne('\App\Models\Employee', 'id', 'leader_id');
    }
}
